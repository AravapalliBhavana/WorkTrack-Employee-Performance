<?php

namespace Database\Seeders;

use App\Models\DailyWorkUpdate;
use App\Models\PerformanceEvaluation;
use App\Models\Task;
use App\Models\TodoItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::updateOrCreate(['email' => 'manager@example.com'], [
            'name' => 'Alex Morgan', 'password' => 'Manager@12345', 'role' => 'manager',
        ]);

        $people = [
            ['name' => 'Olivia Chen', 'email' => 'olivia@example.com'],
            ['name' => 'Noah Williams', 'email' => 'noah@example.com'],
            ['name' => 'Ava Patel', 'email' => 'ava@example.com'],
            ['name' => 'Ethan Brooks', 'email' => 'ethan@example.com'],
        ];
        $employees = [];
        foreach ($people as $person) {
            $employees[] = User::updateOrCreate(['email' => $person['email']], [
                'name' => $person['name'], 'password' => 'Employee@123', 'role' => 'employee',
            ]);
        }

        if (Task::exists()) return; // Keep demo records stable if the seeder is run again.

        $today = Carbon::today();
        $samples = [
            ['Build employee overview page', 'Create responsive KPI cards and employee summary.', 0, 3, 'high', 'in_progress'],
            ['Fix login validation', 'Improve validation messages and handle invalid credentials.', 1, 1, 'high', 'completed'],
            ['Prepare weekly report', 'Summarise progress and blockers for the weekly review.', 2, -2, 'medium', 'pending'],
            ['API integration tests', 'Add coverage for task assignment and status updates.', 3, 4, 'medium', 'in_progress'],
            ['Update onboarding guide', 'Review setup instructions and screenshots.', 0, -1, 'low', 'pending'],
            ['Database performance review', 'Check indexes and query performance.', 1, 2, 'medium', 'completed'],
            ['Dashboard accessibility pass', 'Review keyboard focus and color contrast.', 2, 1, 'low', 'in_progress'],
            ['Release checklist', 'Validate pre-release checks with the team.', 3, -3, 'high', 'pending'],
        ];
        $tasks = [];
        foreach ($samples as $i => [$title, $description, $personIndex, $offset, $priority, $status]) {
            $task = Task::create([
                'title' => $title, 'description' => $description,
                'employee_id' => $employees[$personIndex]->id, 'assigned_by' => $manager->id,
                'due_date' => $today->copy()->addDays($offset), 'priority' => $priority, 'status' => $status,
            ]);
            $tasks[] = $task;
            if ($i < 6) {
                DailyWorkUpdate::create([
                    'task_id' => $task->id, 'employee_id' => $employees[$personIndex]->id,
                    'work_date' => $today->copy()->subDays(($i % 4)),
                    'completed_work' => [
                        'Created the first draft and reviewed it with the team.',
                        'Resolved the validation edge cases and verified the happy path.',
                        'Collected inputs and outlined the remaining report sections.',
                        'Added test cases and documented two follow-up scenarios.',
                        'Updated the onboarding notes and requested peer review.',
                        'Reviewed slow queries and confirmed the expected indexes.',
                    ][$i],
                    'pending_work' => $status === 'completed' ? null : 'Finish review and share the final update.',
                    'hours_spent' => [3.5, 4, 2, 5, 1.5, 3][$i],
                    'status' => $status === 'completed' ? 'completed' : 'in_progress',
                ]);
            }
        }

        foreach ([[$employees[0], 90, 85, 95, 88, 'Consistently communicates progress and delivers high-quality work.'], [$employees[1], 82, 90, 88, 86, 'Strong ownership and good attention to detail.'], [$employees[2], 78, 80, 92, 84, 'Good collaboration; continue improving estimation.']] as [$employee, $completion, $deadlines, $updates, $quality, $feedback]) {
            PerformanceEvaluation::updateOrCreate([
                'employee_id' => $employee->id, 'manager_id' => $manager->id,
                'period_start' => $today->copy()->subDays(30)->toDateString(), 'period_end' => $today->toDateString(),
            ], [
                'task_completion_score' => $completion, 'deadline_score' => $deadlines,
                'daily_updates_score' => $updates, 'work_quality_score' => $quality,
                'overall_score' => round($completion*.40 + $deadlines*.25 + $updates*.15 + $quality*.20, 2),
                'strengths' => 'Communicates progress and collaborates with the team.',
                'improvement_areas' => 'Continue refining estimates and prioritisation.', 'feedback' => $feedback,
            ]);
        }

        foreach ($tasks as $task) {
            TodoItem::firstOrCreate([
                'employee_id' => $task->employee_id, 'task_id' => $task->id, 'title' => 'Review and test: '.$task->title,
            ], [
                'description' => 'Check the acceptance criteria and share any blockers.',
                'due_date' => $today->copy()->addDays(2),
                'status' => $task->status === 'completed' ? 'completed' : 'pending',
            ]);
        }
    }
}
