<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectComment;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('owner_id', Auth::id())->get();
        return Inertia::render('project/Index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        return Inertia::render('project/Create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'required',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'status' => 'required',
            'description' => 'required'
        ]);

        $thumbnail = $request->file('thumbnail');
        $thumbnail_name = time() . '.' . $thumbnail->getClientOriginalName();
        $thumbnail->move(public_path('images'), $thumbnail_name);

        Project::create([
            'owner_id' => Auth::id(),
            'title' => $request->title,
            'thumbnail' => $thumbnail_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return redirect()->route('project.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('project/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        return Inertia::render('project/Create', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'required',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'status' => 'required',
            'description' => 'required'
        ]);

        $project = Project::findOrFail($id);
        if($request->file('thumbnail')){
            $thumbnail = $request->file('thumbnail');
            $thumbnail_name = time() . '.' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('images'), $thumbnail_name);
            $project->update(['thumbnail' => $thumbnail_name]);
        }

        $project->update([
            'owner_id' => Auth::id(),
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return redirect()->route('project.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Project::findOrFail($id)->destroy();
        return redirect()->route('project.index');
    }

    public function storeComment(Request $request){
        $project = Project::findOrFail($request->project_id);

        // $request->comment->filter(comment => comment.id == $request->project_id);

        $filtered = array_filter($request->comment, function($comment) use ($request){
            return $comment['id'] == $request->project_id;
        });
        
        foreach($filtered as $filter){
            ProjectComment::create([
                'comment' => $filter['comment'],
                'user_id' => Auth::id(),
                'project_id' => $request->project_id
            ]);
        }

        return redirect('/?show_freelance_project=true');
    }
}
