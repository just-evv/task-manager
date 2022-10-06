<?php

namespace Tests\Feature;

use App\Models\{Task, TaskStatus, User};
use Tests\TestCase;

/**
 * @covers \App\Models\TaskStatus
 * @covers \App\Http\Controllers\TaskStatusController
 * @covers \App\Policies\TaskStatusPolicy
 */
class TaskStatusControllerTest extends TestCase
{
    private User $user;
    private array $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->request = ['name' => 'Testing Status'];
    }

    public function testIndex()
    {
        $this->get(route('task_statuses.index'))
            ->assertOk()
            ->assertViewIs('task_statuses.index');
    }

    public function testCreate()
    {
        $this->get(route('task_statuses.create'))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('task_statuses.create'))
            ->assertOk()
            ->assertViewIs('task_statuses.create');
    }

    public function testStore()
    {
        $this->post(route('task_statuses.store', $this->request))
            ->assertStatus(403);
        $this->followingRedirects()
            ->actingAs($this->user)
            ->post(route('task_statuses.store', $this->request))
            ->assertSessionDoesntHaveErrors()
            ->assertViewIs('task_statuses.index')
            ->assertSee($this->request);
        $this->assertDatabaseHas('task_statuses', $this->request);
    }

    public function testEdit()
    {
        $taskStatus = TaskStatus::factory()->createOne();
        $this->get(route('task_statuses.edit', $taskStatus))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->get(route('task_statuses.edit', $taskStatus))
            ->assertOk()
            ->assertViewIs('task_statuses.edit');
    }

    public function testUpdate()
    {
        $taskStatus = TaskStatus::factory()->createOne();
        $this->patch(route('task_statuses.update', $taskStatus), $this->request)
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->patch(route('task_statuses.update', $taskStatus), $this->request)
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionDoesntHaveErrors();
        $this->get(route('task_statuses.index'))
            ->assertSee($this->request);
        $this->assertDatabaseHas('task_statuses', $this->request);
    }

    public function testDestroyStatusNotAssigned()
    {
        $taskStatus = TaskStatus::factory()->createOne();

        $this->delete(route('task_statuses.destroy', $taskStatus))
            ->assertStatus(403);

        $this->followingRedirects()
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $taskStatus))
            ->assertOk()
            ->assertSee('Статус успешно удалён');

        $this->assertDatabaseMissing('task_statuses', $taskStatus->toArray());
        $this->assertModelMissing($taskStatus);
    }

    public function testDestroyStatusAssigned()
    {
        $taskStatus = TaskStatus::factory()->createOne();
        Task::factory()->createOne(['status_id' => $taskStatus]);

        $this->delete(route('task_statuses.destroy', $taskStatus))
            ->assertStatus(403);

        $this->followingRedirects()
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $taskStatus))
            ->assertOk()
            ->assertSee('Не удалось удалить статус');

        $this->assertDatabaseHas('task_statuses', $taskStatus->toArray());
        $this->assertModelExists($taskStatus);
    }
}
