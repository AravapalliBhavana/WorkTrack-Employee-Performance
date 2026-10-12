<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('todo_items', function (Blueprint $table) { $table->id(); $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete(); $table->foreignId('task_id')->nullable()->constrained()->nullOnDelete(); $table->string('title'); $table->text('description')->nullable(); $table->date('due_date')->nullable(); $table->enum('status',['pending','in_progress','completed'])->default('pending'); $table->timestamps(); $table->index(['employee_id','status']); }); }
 public function down(): void { Schema::dropIfExists('todo_items'); }
};
