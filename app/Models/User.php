<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed']; }
    public function assignedTasks(): HasMany { return $this->hasMany(Task::class, 'employee_id'); }
    public function workUpdates(): HasMany { return $this->hasMany(DailyWorkUpdate::class, 'employee_id'); }
    public function evaluations(): HasMany { return $this->hasMany(PerformanceEvaluation::class, 'employee_id'); }
}
