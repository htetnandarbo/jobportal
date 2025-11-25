<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontController extends Controller
{
    // Welcome
    public function welcome()
    {
        return Inertia::render('Welcome');
    }

    // Companies
    public function companies()
    {
        return Inertia::render('Companies');
    }

    // Partner Networks
    public function partnerNetworks()
    {
        return Inertia::render('PartnerNetworks');
    }

    // Career Resources
    public function careerResources()
    {
        return Inertia::render('CareerResources');
    }
}
