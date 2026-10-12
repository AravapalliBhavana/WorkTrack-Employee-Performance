<?php
namespace App\Http\Controllers;
use App\Models\PerformanceEvaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class PerformanceEvaluationController extends Controller
{
 public function index() { $query=PerformanceEvaluation::with(['employee','manager'])->latest('period_end'); if(auth()->user()->role==='employee') $query->where('employee_id',auth()->id()); return view('evaluations.index',['evaluations'=>$query->paginate(15)]); }
 public function create() { abort_unless(auth()->user()->role==='manager',403); return view('evaluations.create',['employees'=>User::where('role','employee')->orderBy('name')->get()]); }
 public function store(Request $request) {
  abort_unless($request->user()->role==='manager',403);
  $data=$request->validate(['employee_id'=>['required',Rule::exists('users','id')->where('role','employee')],'period_start'=>['required','date'],'period_end'=>['required','date','after_or_equal:period_start'],'task_completion_score'=>['required','numeric','min:0','max:100'],'deadline_score'=>['required','numeric','min:0','max:100'],'daily_updates_score'=>['required','numeric','min:0','max:100'],'work_quality_score'=>['required','numeric','min:0','max:100'],'strengths'=>['nullable','string','max:5000'],'improvement_areas'=>['nullable','string','max:5000'],'feedback'=>['nullable','string','max:10000']]);
  $data['overall_score']=round($data['task_completion_score']*.40+$data['deadline_score']*.25+$data['daily_updates_score']*.15+$data['work_quality_score']*.20,2); $data['manager_id']=$request->user()->id; PerformanceEvaluation::create($data);
  return redirect()->route('evaluations.index')->with('success','Performance evaluation saved.');
 }
}
