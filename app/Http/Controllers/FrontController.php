<?php

namespace App\Http\Controllers;

use App\Models\CareerResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\PartnerNetwork;
use App\Models\Post;
use App\Models\Project;
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

        $projects = null;
        if($request->show_freelance_project){
            $projects = Project::with('comments', 'comments.user')->get();
        }

        $categories = Category::all();
        return Inertia::render('Welcome', [
            'jobs' => $jobs,
            'categories' => $categories,
            'projects' => $projects
        ]);
    }

    // Companies
    public function companies()
    {
        $companies = Company::all();
        return Inertia::render('Companies', [
            'companies' => $companies
        ]);
    }

    // Partner Networks
    public function partnerNetworks()
    {
        $partnerNetworks = PartnerNetwork::all();
        return Inertia::render('PartnerNetworks', [
            'partnerNetworks' => $partnerNetworks
        ]);
    }

    // Career Resources
    public function careerResources()
    {
        $careerResources = CareerResource::all();
        return Inertia::render('CareerResources', [
            'careerResources' => $careerResources
        ]);
    }
}
