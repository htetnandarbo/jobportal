<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontController extends Controller
{
    // Welcome
    public function welcome()
    {
        $categories = Category::all();
        $jobs = Post::all();
        return Inertia::render('Welcome', compact('categories', 'jobs'));
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
