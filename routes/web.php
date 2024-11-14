<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PracticumController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PracticumAssistantController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware(['role:student'])->group(function () {
        Route::resource('student', StudentController::class)->only(['index']);
        Route::patch('/student', [StudentController::class, 'update'])->name('student.update');
        Route::post('/student', [StudentController::class, 'applyAssistant'])->name('student.apply');
        Route::resource('registrations', RegistrationController::class)->only(['index', 'store', 'destroy']);
    });
    Route::middleware(['role:assistant'])->group(function () {
        Route::resource('pracassistants', PracticumAssistantController::class)->only(['index', 'store', 'show', 'destroy']);
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('practicums', PracticumController::class)->except(['create', 'show', 'edit']);
        Route::resource('rooms', RoomController::class)->except(['create', 'show', 'edit']);
        Route::resource('assistants', AssistantController::class)->except(['create', 'show', 'edit']);
        Route::resource('schedules', ScheduleController::class)->except(['create', 'show', 'edit']);
    });
    Route::middleware(['role:admin|assistant'])->group(function () {
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
        Route::patch('/approvals/{id}/approve-registration', [ApprovalController::class, 'approveRegistration'])->name('approve.registration');
        Route::patch('/approvals/{id}/reject-registration', [ApprovalController::class, 'rejectRegistration'])->name('reject.registration');
        Route::patch('/approvals/{id}/approve-assistant', [ApprovalController::class, 'approveAssistant'])->name('approve.assistant');
        Route::patch('/approvals/{id}/reject-assistant', [ApprovalController::class, 'rejectAssistant'])->name('reject.assistant');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
