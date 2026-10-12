<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\DailyWorkUpdate;
use App\Models\PerformanceEvaluation;
use App\Models\TodoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'manager') {
            return view('dashboard.manager', [
                'employeeCount' => User::where('role', 'employee')->count(),
                'taskCount' => Task::count(),
                'openTasks' => Task::whereIn('status', ['pending', 'in_progress'])->count(),
                'overdueTasks' => Task::whereDate('due_date', '<', today())->whereNotIn('status', ['completed'])->count(),
                'openTodos' => TodoItem::where('status','!=','completed')->count(),
                'recentUpdates' => DailyWorkUpdate::with(['employee', 'task'])->latest()->take(8)->get(),
                'employees' => User::where('role', 'employee')->orderBy('name')->get(),
            ]);
        }
        return view('dashboard.employee', [
            'tasks' => Task::where('employee_id', $user->id)->with('manager')->latest()->get(),
            'updates' => DailyWorkUpdate::where('employee_id', $user->id)->with('task')->latest('work_date')->take(8)->get(),
            'evaluations' => PerformanceEvaluation::where('employee_id', $user->id)->with('manager')->latest()->take(5)->get(),
            'openTodos' => TodoItem::where('employee_id',$user->id)->where('status','!=','completed')->count(),
        ]);
    }
    public function createEmployee() { return view('dashboard.create-employee'); }
    public function storeEmployee(Request $request)
    {
        $data = $request->validate(['name' => ['required','string','max:255'], 'email' => ['required','email','max:255','unique:users,email'], 'password' => ['required','string','min:8','confirmed']]);
        User::create(['name'=>$data['name'], 'email'=>$data['email'], 'password'=>Hash::make($data['password']), 'role'=>'employee']);
        return redirect()->route('dashboard')->with('success', 'Employee created successfully.');
    }
}
