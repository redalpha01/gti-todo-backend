<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $routePrefix = 'api.tasks';

    private string $basePath = '/tasks/';

    public function test_can_get_task_list(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route("{$this->routePrefix}.index"));

        $response->assertOk();

        $response->assertJson([
            'data' => [
                $task->toArray()
            ]
        ]);
    }

    public function test_can_get_single_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route("{$this->routePrefix}.show", $task));

        $response->assertOk();

        $response->assertJson([
            'data' => $task->toArray()
        ]);
    }

    public function test_can_store_task(): void {

        $task = Task::factory()->make();

        $response = $this->postJson(
            route("{$this->routePrefix}.store"),
            $task->toArray()
        );

        $response->assertCreated();

        $response->assertJson([
            'data' => ['description' => $task->description]
        ]);

        $this->assertDatabaseHas(
            'tasks',
            $task->toArray()
        );
    }

    public function test_can_update_task(): void {
        $existingTask = Task::factory()->create();
        $newTask = Task::factory()->make();

        $response = $this->putJson(
            route("{$this->routePrefix}.update", $existingTask),
            $newTask->toArray()
        );

        $response->assertJson([
            'data' => [
                'id' => $existingTask->id,
                'description' => $newTask->description,
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_can_delete_task(): void {
        $existingTask = Task::factory()->create();

        $this->deleteJson(
            route($this->routePrefix . '.destroy', $existingTask)
        )->assertNoContent();

        $this->assertDatabaseMissing(
            'tasks',
            $existingTask->toArray()
        );
    }
}
