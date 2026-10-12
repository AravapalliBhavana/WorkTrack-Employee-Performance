<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'employee_id', 'assigned_by', 'due_date', 'priority', 'status'];
    protected function casts(): array { return ['due_date' => 'date']; }
    public function employee(): BelongsTo { return $this->belongsTo(User::class, 'employee_id'); }
    public function manager(): BelongsTo { return $this->belongsTo(User::class, 'assigned_by'); }
    public function updates() { return $this->hasMany(DailyWorkUpdate::class); }
}
