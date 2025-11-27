<?php

namespace App\Http\Controllers;

use App\Models\CareerResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CareerResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careerResources = CareerResource::all();
        return Inertia::render('career-resources/Index', compact('careerResources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('career-resources/CreateEdit', [
            'careerResource' => new CareerResource(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'youtube_src' => 'required',
        ]);

        CareerResource::create($validated);

        return redirect()->route('career-resources.index')->with('success', 'Career Resource created successfully.');
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
        return Inertia::render('career-resources/CreateEdit', [
            'careerResource' => CareerResource::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'youtube_src' => 'required',
        ]);

        CareerResource::find($id)->update($validated);

        return redirect()->route('career-resources.index')->with('success', 'Career Resource updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $careerResource = CareerResource::find($id);
        $careerResource->delete();

        return redirect()->route('career-resources.index')->with('success', 'Career Resource deleted successfully.');
    }
}
