<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role updated!');
    }
}