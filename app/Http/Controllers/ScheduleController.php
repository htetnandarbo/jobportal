<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('schedules/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $candidate = User::findOrFail($request->user_id);
        $job_id = $request->job_id;
        $application_id = $request->application_id;

         return Inertia::render('schedules/Create', [
            'candidate' => $candidate,
            'job_id' => $job_id,
            'application_id' => $application_id
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidate_id' => 'required|exists:users,id',
            'scheduleDate' => 'required|date',
            'description' => 'required|string|max:500',
            'job_id' => 'required',
            'application_id' => 'required'
        ]);
        
        Schedule::create([
            'candidate_id' => $validated['candidate_id'],
            'interview_time' => $validated['scheduleDate'],
            'description' => $validated['description'],
            'employer_id' => Auth::id(), // Assuming employer is the authenticated user
            'job_id' => $validated['job_id'],
            'application_id' => $validated['application_id']
        ]);

        
        return redirect()->route('applications.index');
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
