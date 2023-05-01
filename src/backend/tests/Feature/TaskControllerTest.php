<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    public function testTaskIsCreatedSuccessfully()
    {
        $payload = [
            'text' => 'Test',
            'engineer_id' => null,
        ];

        $this->json('post', 'api/tasks', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'text',
                        'engineer_id',
                    ]
                ]
            );
        $this->assertDatabaseHas('tasks', $payload);
    }

    public function testTaskIsCreatedFail()
    {
        $payload = [
            'text' => 'Test',
            'engineer_id' => 100,   // Несуществующий инженер
        ];

        $this->json('post', 'api/tasks', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'message',
                    'errors' => [
                        'engineer_id'
                    ]
                ]
            );
    }

    public function testIndexReturnsDataInValidFormat()
    {
        $this->json('get', 'api/tasks')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'text',
                            'status_id',
                            'engineer_id',
                        ]
                    ]
                ]
            );
    }

    public function testIndexReturnsDataInValidFormatFilter()
    {
        $this->json('get', 'api/tasks?status=Создана')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'text',
                            'engineer_id',
                        ]
                    ]
                ]
            );
    }

    public function testTaskIsShownCorrectly()
    {

        $taskData = [
            'text' => $this->faker->text,
            'engineer_id' => null,
            'status_id' => 1
        ];

        $task = Task::create(
            $taskData
        );

        $this->json('get', "api/tasks/$task->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'data' => [
                        'id' => $task->id,
                        'text' => $task->text,
                        'status_id'  => $task->status_id,
                        'engineer_id' => $task->engineer_id,
                        'created_at' => $task->created_at,
                        'updated_at' => $task->updated_at,
                    ]
                ]
            );
    }

    public function testTaskIsDestroyed()
    {
        $taskData = [
            'text' => $this->faker->text,
            'engineer_id' => null,
            'status_id' => 1
        ];

        $task = Task::create(
            $taskData
        );

        $this->json('delete', "api/tasks/$task->id")
            ->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('tasks', $taskData);
    }

}
