<?php

namespace Tests\Feature\Models;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_position_increments_on_create(): void
    {
        $firstTask = Task::factory()->create();
        $firstPosition = $firstTask->position;

        $secondTask = Task::factory()->create();
        $secondPosition = $secondTask->position;

        $this->assertSame($firstPosition + 1, $secondPosition);
    }

    public function test_list_position_is_updated_on_task_position_lowered(): void
    {
        $tasks = Task::factory()->count(10)->create();

        // We keep a reference to the tasks from the third to the eight position as we expect them to move
        $tasksThatWillMove = Task::whereBetween('position', [3, 8])->get();

        // We move the ninth task to the third position
        $taskToUpdate = $tasks[8];
        $taskToUpdate->position = 3;
        $taskToUpdate->save();

        $tasks = Task::orderBy('position')->get();

        foreach ($tasks as $task) {
            if ($task->position === 3) {
                $this->assertSame($taskToUpdate->id, $task->id);
            }

            if ($task->position > 3 && $task->position < 9) {
                $taskThatHasMoved = $tasksThatWillMove->first(static function (Task $taskThatHasMoved) use ($task) {
                    return $taskThatHasMoved->id === $task->id;
                });

                $this->assertSame($taskThatHasMoved->position + 1, $task->position);
            }
        }
    }

    public function test_list_position_is_updated_on_task_position_elevated(): void
    {
        $tasks = Task::factory()->count(10)->create();

        // We keep a reference to the tasks from the fourth to the ninth position as we expect them to move
        $tasksThatWillMove = Task::whereBetween('position', [3, 9])->get();

        // We move the third task to the ninth position
        $taskToUpdate = $tasks[2];
        $taskToUpdate->position = 9;
        $taskToUpdate->save();

        $tasks = Task::orderBy('position')->get();

        foreach ($tasks as $task) {
            if ($task->position === 9) {
                $this->assertSame($taskToUpdate->id, $task->id);
            }

            if ($task->position > 3 && $task->position < 9) {
                $taskThatHasMoved = $tasksThatWillMove->first(static function (Task $taskThatHasMoved) use ($task) {
                    return $taskThatHasMoved->id === $task->id;
                });

                $this->assertSame($taskThatHasMoved->position - 1, $task->position);
            }
        }
    }
}
