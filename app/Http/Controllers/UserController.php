<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('role', 'admin')
        ->when($request->q, function($query) use($request){
            $query->where('name', 'like', '%' . $request->q . '%')
            ->orWhere('email', 'like', '%'.$request->q.'%');
        })
        ->get();
        return Inertia::render('user/Index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        return Inertia::render('user/CreateEdit', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return redirect()->route('user.index');
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
        $user = User::findOrFail($id);
        return Inertia::render('user/CreateEdit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'. $id,
        ]);

        if($request->password != null){
            $request->validate([
                'password' => 'required|min:8'
            ]);
            User::findOrFail($id)->update($request->all());
        }else{
            $request = Arr::except($request->all(), 'password');
            User::findOrFail($id)->update($request);
        };


        

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back();
    }

    public function employerIndex(Request $request){
        $users = User::where('role', 'employer')
        ->when($request->q, function($query) use($request){
            $query->where('name', 'like', '%'.$request->q.'%')
            ->orWhere('email', 'like', '%'.$request->q.'%');
        })
        ->get();
        return Inertia::render('employers/Index', compact('users'));
    }

    public function deleteEmployer($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('employers.index');
    }

    public function jobSeekerIndex(Request $request){
       $users = User::where('role', 'job-seeker')
        ->when($request->q, function($query) use($request){
            $query->where('name', 'like', '%'.$request->q.'%')
            ->orWhere('email', 'like', '%'.$request->q.'%');
        })
        ->get();
        return Inertia::render('job-seeker/Index', compact('users')); 
    }

    public function deleteJobSeeker($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('job-seeker.index');
    }
}
