<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return Inertia::render('companies/Index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('companies/CreateEdit', [
            'company' => new Company(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo_name = time() . '.' . $logo->getClientOriginalName();
            $logo->move(public_path('images'), $logo_name);
            $validated['logo'] = $logo_name;
        }

        Company::create($validated);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
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
        return Inertia::render('companies/CreateEdit', [
            'company' => Company::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url',
        ]);
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo_name = time() . '.' . $logo->getClientOriginalName();
            $logo->move(public_path('images'), $logo_name);
            $validated['logo'] = $logo_name;

            // delete old file
            $old_file = Company::find($id)->logo;
            if ($old_file) {
                unlink(public_path('images') . '/' . $old_file);
            }
        } else {
            $validated['logo'] = Company::find($id)->logo;
        }

        Company::find($id)->update($validated);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::find($id);
        
        // delete old file
        $old_file = $company->logo;
        if ($old_file) {
            unlink(public_path('images') . '/' . $old_file);
        }

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
