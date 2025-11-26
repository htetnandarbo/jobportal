<?php

namespace App\Http\Controllers;

use App\Models\FaqQuestion;
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

        dd($request->all());

        $faqQuestion = FaqQuestion::create([
            'user_id' => Auth::id(),
            'question' => $request->question,
        ]);

        foreach ($request->optionAnswer as $option) {
            // TODO: Create FAQ option and answer
        }



        // TODO: Handle optionAnswer array - create related FAQ options and answers
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
