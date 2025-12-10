<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function apply(Request $request, Task $task)
{
    if (!auth()->user()->isStudent()) {
        abort(403);
    }

    // Check if already applied to 5 tasks
    if (auth()->user()->appliedTasks()->count() >= 5) {
        return redirect()->back()->with('error', 'You can only apply to 5 tasks maximum!');
    }

    $request->validate([
        'priority' => 'required|integer|min:1|max:5'
    ]);

    auth()->user()->appliedTasks()->attach($task->id, ['priority' => $request->priority]);
    return redirect()->back()->with('success', 'Application sent!');
}

    public function cancel(Task $task)
    {
        if (!auth()->user()->isStudent()) {
            abort(403);
        }

        auth()->user()->appliedTasks()->detach($task->id);
        return redirect()->back()->with('success', 'Application cancelled!');
    }
}