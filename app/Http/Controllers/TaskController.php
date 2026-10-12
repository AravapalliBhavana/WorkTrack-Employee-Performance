<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['employee', 'manager'])->latest();
        if ($request->user()->role === 'employee') {
            $query->where('employee_id', $request->user()->id);
        } else {
            if ($request->filled('employee_id')) $query->where('employee_id', $request->integer('employee_id'));
            if ($request->filled('status')) $query->where('status', $request->string('status'));
            if ($request->filled('priority')) $query->where('priority', $request->string('priority'));
        }
        return view('tasks.index', [
            'tasks' => $query->paginate(15)->withQueryString(),
            'employees' => User::where('role', 'employee')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'manager', 403);
        return view('tasks.create', ['employees' => User::where('role', 'employee')->orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->role === 'manager', 403);
        $data = $request->validate([
            'title' => ['required','string','max:255'], 'description' => ['nullable','string','max:10000'],
            'employee_id' => ['required', Rule::exists('users','id')->where('role','employee')],
            'due_date' => ['required','date'], 'priority' => ['required','in:low,medium,high'],
            'status' => ['nullable','in:pending,in_progress,completed'],
        ]);
        $data['assigned_by'] = $request->user()->id;
        $data['status'] = $data['status'] ?? 'pending';
        Task::create($data);
        return redirect()->route('tasks.index')->with('success', 'Task created and assigned successfully.');
    }

    public function edit(Task $task)
    {
        abort_unless(auth()->user()->role === 'manager', 403);
        return view('tasks.edit', [
            'task' => $task,
            'employees' => User::where('role', 'employee')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($request->user()->role === 'manager', 403);
        $data = $request->validate([
            'title' => ['required','string','max:255'], 'description' => ['nullable','string','max:10000'],
            'employee_id' => ['required', Rule::exists('users','id')->where('role','employee')],
            'due_date' => ['required','date'], 'priority' => ['required','in:low,medium,high'],
            'status' => ['required','in:pending,in_progress,completed'],
        ]);
        $task->update($data);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Request $request, Task $task)
    {
        abort_unless($request->user()->role === 'manager', 403);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        abort_unless($request->user()->role === 'employee' && $task->employee_id === $request->user()->id, 403);
        $data = $request->validate(['status' => ['required','in:pending,in_progress,completed']]);
        $task->update($data);
        return back()->with('success', 'Task status updated.');
    }
}
