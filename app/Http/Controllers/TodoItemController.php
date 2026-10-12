<?php
namespace App\Http\Controllers;
use App\Models\TodoItem;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class TodoItemController extends Controller
{
 public function index(Request $request) {
  $query = TodoItem::with(['employee','task'])->latest();
  if ($request->user()->role === 'employee') $query->where('employee_id',$request->user()->id);
  elseif ($request->filled('employee_id')) $query->where('employee_id',$request->integer('employee_id'));
  if ($request->filled('status')) $query->where('status',$request->input('status'));
  return view('todos.index',['items'=>$query->paginate(20)->withQueryString()]);
 }
 public function store(Request $request) {
  abort_unless($request->user()->role === 'employee',403);
  $data=$request->validate(['title'=>['required','string','max:255'],'description'=>['nullable','string'],'task_id'=>['nullable',Rule::exists('tasks','id')->where('employee_id',$request->user()->id)],'due_date'=>['nullable','date']]);
  $data['employee_id']=$request->user()->id; $data['status']='pending'; TodoItem::create($data);
  return back()->with('success','To-do item added.');
 }
 public function update(Request $request, TodoItem $todo) {
  abort_unless($request->user()->role==='manager' || $todo->employee_id===$request->user()->id,403);
  $data=$request->validate(['title'=>['sometimes','required','string','max:255'],'description'=>['sometimes','nullable','string'],'due_date'=>['sometimes','nullable','date'],'status'=>['sometimes','required',Rule::in(['pending','in_progress','completed'])]]);
  $todo->update($data); return back()->with('success','To-do item updated.');
 }
 public function destroy(Request $request, TodoItem $todo) {
  abort_unless($request->user()->role==='manager' || $todo->employee_id===$request->user()->id,403);
  $todo->delete(); return back()->with('success','To-do item deleted.');
 }
}
