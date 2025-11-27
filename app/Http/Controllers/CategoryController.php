<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('employer_id', Auth::id())->get();
        return Inertia::render('categories/Index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('categories/CreateEdit', [
            'category' => new Category(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
    ]);

    $validated['employer_id'] = Auth::id();
        
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalName();
        $image->move(public_path('images'), $image_name);
        $validated['image'] = $image_name;
    }

    Category::create($validated);

    return redirect()->route('categories.index')->with('success', 'Category created');
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
        return Inertia::render('categories/CreateEdit', [
            'category' => Category::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalName();
            $image->move(public_path('images'), $image_name);
            $validated['image'] = $image_name;

            // delete old file
            $old_file = Category::find($id)->image;
            if ($old_file) {
                unlink(public_path('images') . '/' . $old_file);
            }
        }

        Category::find($id)->update($validated);

        return redirect()->route('categories.index')->with('success', 'Unit Category updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::find($id)->delete();

        return redirect()->route('categories.index')->with('success', 'Unit Category deleted');
    }
}
