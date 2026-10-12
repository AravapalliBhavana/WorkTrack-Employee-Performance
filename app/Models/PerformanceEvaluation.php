<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PerformanceEvaluation extends Model
{
 protected $fillable=['employee_id','manager_id','period_start','period_end','task_completion_score','deadline_score','daily_updates_score','work_quality_score','overall_score','strengths','improvement_areas','feedback'];
 protected function casts(): array { return ['period_start'=>'date','period_end'=>'date','task_completion_score'=>'decimal:2','deadline_score'=>'decimal:2','daily_updates_score'=>'decimal:2','work_quality_score'=>'decimal:2','overall_score'=>'decimal:2']; }
 public function employee(): BelongsTo { return $this->belongsTo(User::class,'employee_id'); }
 public function manager(): BelongsTo { return $this->belongsTo(User::class,'manager_id'); }
}
