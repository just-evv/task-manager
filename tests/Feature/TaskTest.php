<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

/**
 * @covers \App\Models\Task
 * @covers \App\Http\Controllers\TaskController
 * @covers \App\Policies\TaskPolicy
 */
class TaskTest extends TestCase
{
    private User $user;
    private Task $task;
    private array $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->createOne();
        $this->request = [
            'name' => 'Task 1',
            'description' => 'description',
            'status_id' => 1,
        ];
        $this->task = Task::factory()->createOne(['created_by_id' => $this->user]);
    }

    public function testTasksIndex()
    {
        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertViewIs('tasks.index');
    }

    public function testCreateTask()
    {
        $this->get(route('tasks.create'))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('tasks.create'))
            ->assertOk()
            ->assertViewIs('tasks.create');
        ;
    }

    public function testStoreTask()
    {
        $this->actingAs($this->user)
            ->post(route('tasks.store', $this->request))
            ->assertRedirect(route('tasks.index'));
        $this->get(route('tasks.index'))
            ->assertSee([$this->request['name']]);
        $this->assertDatabaseHas('tasks', $this->request);
    }

    public function testShowTask()
    {
        $this->get(route('tasks.show', $this->task))
            ->assertSee([$this->task->name]);
    }

    public function testUpdateTask()
    {
        $request = ['name' => 'new task',
            'status_id' => 1];
        $this->patch(route('tasks.update', $this->task), $request)
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->patch(route('tasks.update', $this->task), $request)
            ->assertRedirect(route('tasks.index'))
            ->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('tasks', $request);
    }

    public function testDestroyTask()
    {
        $this->delete(route('tasks.destroy', $this->task))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $this->task))
            ->assertRedirect(route('tasks.index'));
        $this->assertModelMissing($this->task);
    }
}
