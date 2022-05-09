<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    private object $user;
    private object $taskStatus;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
    }

    public function testTasksIndex()
    {
        $this->get(route('tasks.index'))
            ->assertOk();
    }

    public function testSeeAsUser()
    {
        $this->actingAs($this->user)
            ->get(route('tasks.index'))
            ->assertSee('Create new task');
    }

    public function testCreateStatus()
    {
        $this->get(route('tasks.create'))
            ->assertOk();
    }

    public function testStoreStatus()
    {
        $assignedUser = User::factory()->create();
        $newTask = [
            'name' => 'task',
            'description' => 'description',
            'status_id' => $this->taskStatus->id,
            'assigned_to_id' => $assignedUser->id,
        ];
        $this->actingAs($this->user)
            ->post(route('tasks.store', $newTask))
            ->assertRedirect(route('tasks.index'));
        //$this->get(route('tasks.index'))
        //    ->assertSee($newTask);
        $this->assertDatabaseHas('tasks', $newTask);
    }
}
