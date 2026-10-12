<?php

namespace App\Http\Controllers;

use App\Models\DailyWorkUpdate;
use App\Models\Task;
use Illuminate\Http\Request;

class DailyWorkUpdateController extends Controller
{
    public function index()
    {
        $query = DailyWorkUpdate::with(['employee','task'])->latest('work_date');
        if (auth()->user()->role === 'employee') $query->where('employee_id', auth()->id());
        return view('updates.index', ['updates' => $query->paginate(15)]);
    }
    public function create()
    {
        $tasks = Task::where('employee_id', auth()->id())->whereNotIn('status', ['completed'])->orderBy('title')->get();
        return view('updates.create', compact('tasks'));
    }
    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'employee', 403);
        $data = $request->validate([
            'task_id' => ['required','exists:tasks,id'], 'work_date' => ['required','date','before_or_equal:today'],
            'completed_work' => ['required','string'], 'pending_work' => ['nullable','string'],
            'hours_spent' => ['required','numeric','min:0','max:24'], 'status' => ['required','in:in_progress,completed,blocked'],
        ]);
        $task = Task::where('id', $data['task_id'])->where('employee_id', auth()->id())->firstOrFail();
        $data['employee_id'] = auth()->id();
        DailyWorkUpdate::create($data);
        if ($data['status'] === 'completed') $task->update(['status' => 'completed']);
        elseif ($task->status === 'pending') $task->update(['status' => 'in_progress']);
        return redirect()->route('updates.index')->with('success', 'Daily work update submitted.');
    }
}
