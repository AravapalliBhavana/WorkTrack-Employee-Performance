<?php
namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use App\Models\DailyWorkUpdate;
use App\Models\PerformanceEvaluation;
use App\Models\TodoItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
class ReportController extends Controller
{
 private function filteredTasks(Request $request) {
  $q=Task::with('employee');
  if($request->filled('employee_id')) $q->where('employee_id',$request->integer('employee_id'));
  if($request->filled('status')) $q->where('status',$request->input('status'));
  if($request->filled('priority')) $q->where('priority',$request->input('priority'));
  if($request->filled('from')) $q->whereDate('due_date','>=',$request->input('from'));
  if($request->filled('to')) $q->whereDate('due_date','<=',$request->input('to'));
  return $q;
 }
 public function index(Request $request) {
  $q=$this->filteredTasks($request); $all=(clone $q)->get();
  $summary=['total'=>$all->count(),'completed'=>$all->where('status','completed')->count(),'in_progress'=>$all->where('status','in_progress')->count(),'pending'=>$all->where('status','pending')->count(),'overdue'=>$all->filter(fn($t)=>$t->status!=='completed' && $t->due_date && $t->due_date->lt(today()))->count()];
  $employees=User::where('role','employee')->orderBy('name')->get();
  $updates=DailyWorkUpdate::with('employee')->whereDate('work_date','>=',$request->input('from',today()->startOfMonth()->toDateString()))->whereDate('work_date','<=',$request->input('to',today()->toDateString()))->latest('work_date')->take(8)->get();
  $evaluations=PerformanceEvaluation::with('employee')->latest('period_end')->take(6)->get();
  $todoCount=TodoItem::where('status','!=','completed')->count();
  return view('reports.index',['tasks'=>$q->latest()->paginate(15)->withQueryString(),'employees'=>$employees,'summary'=>$summary,'updates'=>$updates,'evaluations'=>$evaluations,'todoCount'=>$todoCount]);
 }
 public function export(Request $request): StreamedResponse {
  $tasks=$this->filteredTasks($request)->latest()->get();
  return response()->streamDownload(function() use($tasks) { $out=fopen('php://output','w'); fputcsv($out,['Task','Employee','Priority','Status','Due date','Overdue']); foreach($tasks as $task) fputcsv($out,[$task->title,$task->employee->name ?? '',$task->priority,$task->status,$task->due_date?->format('Y-m-d'),($task->status!=='completed' && $task->due_date && $task->due_date->lt(today()))?'Yes':'No']); fclose($out); },'worktrack-task-report.csv',['Content-Type'=>'text/csv']);
 }
}
