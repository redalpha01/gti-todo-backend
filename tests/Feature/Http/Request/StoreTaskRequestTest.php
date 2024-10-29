<?php

namespace Tests\Feature\Http\Request;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTaskRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_description_is_required(): void
    {
        $property = Task::factory()->make([
            'description' => null,
        ]);

        $this->postJson(
            route('api.tasks.store'),
            $property->toArray(),
        )->assertJsonValidationErrors('description');
    }
}
