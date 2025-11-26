<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user_id ?? Auth::id();
        $hideButton = $request->isHide ?? false;
        $previousUrl = url()->previous();
        $resume = Resume::where('user_id', $userId)->first();

        if($request->application_id){
            $application = Application::findOrFail($request->application_id);
            if($application->status != 'accepted' && $application->status != 'rejected'){
                $application->update($request->only('status'));
            }
        }
        return Inertia::render('resume/Index', compact('resume', 'hideButton', 'previousUrl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $resume = New Resume();
        return Inertia::render('resume/CreateEdit', compact('resume'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'image' => 'required',
            'title' => 'required|string',
            'summary' => 'required',
            'experience_years' => 'nullable',
            'expected_salary' => 'nullable', 
            'job_level' => 'required',
            'job_type' => 'required',
            'location' => 'required', 
            'skills' => 'required',
            'languages' => 'required',
            'education' => 'required',
            'certifications' => 'required',
            'social' => 'required',
        ]);

        $validated['user_id'] = Auth::id();


        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalName();
        $image->move(public_path('images'), $image_name);
        $validated['image'] = $image_name;

        Resume::create($validated);


        return redirect()->route('resume.index');
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
        $resume = Resume::findOrFail($id);
        return Inertia::render('resume/CreateEdit', compact('resume'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'title' => 'required|string',
            'summary' => 'required',
            'experience_years' => 'nullable',
            'expected_salary' => 'nullable', 
            'job_level' => 'required',
            'job_type' => 'required',
            'location' => 'required', 
            'skills' => 'required',
            'languages' => 'required',
            'education' => 'required',
            'certifications' => 'required',
            'social' => 'required',
        ]);

        $validated['user_id'] = Auth::id();

        if($request->image){
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalName();
            $image->move(public_path('images'), $image_name);
            $validated['image'] = $image_name;
        }

        Resume::findOrFail($id)->update($validated);


        return redirect()->route('resume.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
