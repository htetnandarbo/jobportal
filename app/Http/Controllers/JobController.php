<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Post::with('category')->get();
        return Inertia::render('jobs/Index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return Inertia::render('jobs/CreateEdit', [
            'job' => new Post(),
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        Post::create([
            'category_id'      => $request->category_id,
            'title'            => $request->title,
            'description'      => $request->description,
            'company_name'     => $request->company_name,
            'location'         => $request->location,
            'salary'           => $request->salary,
            'skills'           => $request->skills,
            'experience_level' => $request->experience_level,
            'post_date'        => Carbon::now(), // current date & time
            'close_date'       => $request->close_date,
        ]);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job created successfully');
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
        $categories = Category::all();
        return Inertia::render('jobs/CreateEdit', [
            'job' => Post::find($id),
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the job by ID
        $job = Post::findOrFail($id);

        // Update the job with request data (except post_date)
        $job->update([
            'category_id'      => $request->category_id,
            'title'            => $request->title,
            'description'      => $request->description,
            'company_name'     => $request->company_name,
            'location'         => $request->location,
            'salary'           => $request->salary,
            'skills'           => $request->skills,
            'experience_level' => $request->experience_level,
            'close_date'       => $request->close_date,
            // 'post_date' stays the same
        ]);

        return redirect()
            ->route('jobs.index')
            ->with('success', 'Job updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::find($id)->delete();
    }
}
