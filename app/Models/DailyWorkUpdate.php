<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyWorkUpdate extends Model
{
    protected $fillable = ['task_id', 'employee_id', 'work_date', 'completed_work', 'pending_work', 'hours_spent', 'status'];
    protected function casts(): array { return ['work_date' => 'date', 'hours_spent' => 'decimal:2']; }
    public function employee(): BelongsTo { return $this->belongsTo(User::class, 'employee_id'); }
    public function task(): BelongsTo { return $this->belongsTo(Task::class); }
}
