<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TodoItem extends Model
{
    protected $fillable = ['employee_id','task_id','title','description','due_date','status'];
    protected function casts(): array { return ['due_date' => 'date']; }
    public function employee() { return $this->belongsTo(User::class, 'employee_id'); }
    public function task() { return $this->belongsTo(Task::class); }
}
