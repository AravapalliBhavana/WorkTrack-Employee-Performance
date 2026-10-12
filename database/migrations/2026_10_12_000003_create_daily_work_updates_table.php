<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration { public function up(): void { Schema::create('daily_work_updates', function (Blueprint $table) { $table->id(); $table->foreignId('task_id')->constrained()->cascadeOnDelete(); $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete(); $table->date('work_date'); $table->text('completed_work'); $table->text('pending_work')->nullable(); $table->decimal('hours_spent',5,2)->default(0); $table->enum('status',['in_progress','completed','blocked'])->default('in_progress'); $table->timestamps(); $table->index(['employee_id','work_date']); }); } public function down(): void { Schema::dropIfExists('daily_work_updates'); } };
