<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DailyWorkUpdateController;
use App\Http\Controllers\PerformanceEvaluationController;
use App\Http\Controllers\TodoItemController;
use App\Http\Controllers\ReportController;

Route::get('/', fn () => redirect()->route('login'));
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:manager')->group(function () {
        Route::get('/employees/create', [DashboardController::class, 'createEmployee'])->name('employees.create');
        Route::post('/employees', [DashboardController::class, 'storeEmployee'])->name('employees.store');

        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

        Route::get('/evaluations/create', [PerformanceEvaluationController::class, 'create'])->name('evaluations.create');
        Route::post('/evaluations', [PerformanceEvaluationController::class, 'store'])->name('evaluations.store');
    });

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::get('/work-updates', [DailyWorkUpdateController::class, 'index'])->name('updates.index');
    Route::get('/work-updates/create', [DailyWorkUpdateController::class, 'create'])->name('updates.create');
    Route::post('/work-updates', [DailyWorkUpdateController::class, 'store'])->name('updates.store');
    Route::get('/evaluations', [PerformanceEvaluationController::class, 'index'])->name('evaluations.index');

    Route::get('/todos', [TodoItemController::class, 'index'])->name('todos.index');
    Route::post('/todos', [TodoItemController::class, 'store'])->middleware('role:employee')->name('todos.store');
    Route::patch('/todos/{todo}', [TodoItemController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}', [TodoItemController::class, 'destroy'])->name('todos.destroy');
});
