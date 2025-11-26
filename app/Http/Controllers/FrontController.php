<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FrontController extends Controller
{
    // Welcome
    public function welcome(Request $request)
    {
        $jobs = Post::with('category', 'applications')
        ->when($request->q, function($query) use($request){
            $query->where('title','like', '%'.$request->q.'%')
            ->orWhere('company_name', 'like', '%'.$request->q.'%')
            ->orWhere('location', 'like', '%'.$request->q.'%')
            ->orWhere('salary','like','%'.$request->q.'%');
        })
        ->when($request->category_id, function($query) use($request){
            $query->where('category_id', $request->category_id);
        })
        ->get();


        $categories = Category::all();
        return Inertia::render('Welcome', [
            'jobs' => $jobs,
            'categories' => $categories
        ]);
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
