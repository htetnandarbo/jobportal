<?php

namespace App\Http\Controllers;

use App\Models\FaqOption;
use App\Models\FaqQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatBotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = FaqQuestion::with(['faqOptions', 'faqOptions.faqAnswer'])->get();
        return Inertia::render('chatbot/Index', compact('faqs'));
    }

    public function front(Request $request)
    {
        dd($request->all());
        return Inertia::render('chatbot/Front');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('chatbot/CreateEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'optionAnswer' => 'required|array'
        ]);


        $faqQuestion = FaqQuestion::create([
            'user_id' => Auth::id(),
            'question' => $request->question,
            'order' => FaqQuestion::count() + 1
        ]);

        foreach ($request->optionAnswer as $option) {
            // Create FAQ option and answer
            $faqOption = $faqQuestion->faqOptions()->create([
                'option_text' => $option['option'] // This will be set when answer is created
            ]);

            $faqOption->faqAnswer()->create([
                'answer_text' => $option['answer']
            ]);
        }



        // TODO: Handle optionAnswer array - create related FAQ options and answers
        return redirect()->route('chat-bot.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $chats = FaqQuestion::where('user_id', $id)->with(['faqOptions', 'faqOptions.faqAnswer'])
        ->when($request->order, function($query) use($request){
            $query->where('order', $request->order);
        })
        ->paginate(10)
        ->withQueryString();
        $user = User::find($id);

        $answer = null;
        if($request->option_id){
            $option = FaqOption::find($request->option_id);
            $answer = $option->faqAnswer;
        }

        if($chats->isEmpty()){
            return redirect()->route('home');
        }

        return Inertia::render('chatbot/Front', compact('chats', 'user', 'answer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        FaqQuestion::destroy($id);
        return redirect()->route('chat-bot.index'); 
    }
}
