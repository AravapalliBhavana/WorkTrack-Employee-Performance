<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('performance_evaluations', function (Blueprint $table) { $table->id(); $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete(); $table->foreignId('manager_id')->constrained('users')->cascadeOnDelete(); $table->date('period_start'); $table->date('period_end'); $table->decimal('task_completion_score',5,2); $table->decimal('deadline_score',5,2); $table->decimal('daily_updates_score',5,2); $table->decimal('work_quality_score',5,2); $table->decimal('overall_score',5,2); $table->text('strengths')->nullable(); $table->text('improvement_areas')->nullable(); $table->text('feedback')->nullable(); $table->timestamps(); $table->index(['employee_id','period_end']); }); } public function down(): void { Schema::dropIfExists('performance_evaluations'); } };
