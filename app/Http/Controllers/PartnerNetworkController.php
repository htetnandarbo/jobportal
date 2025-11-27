<?php

namespace App\Http\Controllers;

use App\Models\PartnerNetwork;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartnerNetworkController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partnerNetworks = PartnerNetwork::all();
        return Inertia::render('partner-networks/Index', compact('partnerNetworks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('partner-networks/CreateEdit', [
            'partnerNetwork' => new PartnerNetwork(),
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

        PartnerNetwork::create($validated);

        return redirect()->route('partner-networks.index')->with('success', 'Partner Network created successfully.');
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
        return Inertia::render('partner-networks/CreateEdit', [
            'partnerNetwork' => PartnerNetwork::find($id),
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
            $old_file = PartnerNetwork::find($id)->logo;
            if ($old_file) {
                unlink(public_path('images') . '/' . $old_file);
            }
        } else {
            $validated['logo'] = PartnerNetwork::find($id)->logo;
        }

        PartnerNetwork::find($id)->update($validated);

        return redirect()->route('partner-networks.index')->with('success', 'Partner Network updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partnerNetwork = PartnerNetwork::find($id);
        $partnerNetwork->delete();

        return redirect()->route('partner-networks.index')->with('success', 'Partner Network deleted successfully.');
    }
}
