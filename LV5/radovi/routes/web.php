<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     // Admin routes
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.users');
    Route::patch('/admin/users/{user}/role', [App\Http\Controllers\AdminController::class, 'updateRole'])->name('admin.updateRole');
    // Task routes
    Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');

    Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');

    Route::post('/tasks/{task}/apply', [App\Http\Controllers\ApplicationController::class, 'apply'])->name('tasks.apply');
Route::delete('/tasks/{task}/cancel', [App\Http\Controllers\ApplicationController::class, 'cancel'])->name('tasks.cancel');

Route::get('/my-tasks', [App\Http\Controllers\TaskController::class, 'myTasks'])->name('tasks.myTasks');
Route::post('/tasks/{task}/accept/{studentId}', [App\Http\Controllers\TaskController::class, 'acceptStudent'])->name('tasks.acceptStudent');
});

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'hr'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');

require __DIR__.'/auth.php';
