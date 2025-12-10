<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create()
    {
        if (!auth()->user()->isNastavnik()) {
            abort(403);
        }
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isNastavnik()) {
            abort(403);
        }

        $request->validate([
            'naziv_rada' => 'required',
            'naziv_rada_en' => 'required',
            'zadatak_rada' => 'required',
            'tip_studija' => 'required',
        ]);

        auth()->user()->tasks()->create($request->all());

        return redirect()->route('tasks.create')->with('success', 'Task created!');
    }

    public function index()
{
    if (!auth()->user()->isStudent()) {
        abort(403);
    }

    $tasks = Task::with('nastavnik')->get();
    return view('tasks.index', compact('tasks'));
}

public function myTasks()
{
    if (!auth()->user()->isNastavnik()) {
        abort(403);
    }

    $tasks = auth()->user()->tasks()->with('applicants', 'acceptedStudent')->get();
    return view('tasks.my-tasks', compact('tasks'));
}

public function acceptStudent(Task $task, $studentId)
{
    if (!auth()->user()->isNastavnik() || $task->user_id !== auth()->id()) {
        abort(403);
    }

    // Check if student applied with priority 1
    $application = $task->applicants()->where('student_id', $studentId)->first();
    
    if (!$application || $application->pivot->priority != 1) {
        return redirect()->back()->with('error', 'You can only accept students who set this task as priority 1!');
    }

    $task->accepted_student_id = $studentId;
    $task->save();

    return redirect()->back()->with('success', 'Student accepted!');
}
}