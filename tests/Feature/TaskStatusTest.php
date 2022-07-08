<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    private User $user;
    private array $request;
    private Model|TaskStatus $taskStatus;
    private Task $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->request = ['name' => 'Testing Status'];
        $this->taskStatus = TaskStatus::factory()->createOne();
        $this->task = Task::factory()->createOne();
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::create
     *
     */
    public function testCreateStatus()
    {
        $this->get(route('task_statuses.create'))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('task_statuses.create'))
            ->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::store
     *
     */
    public function testStoreStatus()
    {
        $this->post(route('task_statuses.store', $this->request))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->post(route('task_statuses.store', $this->request))
            ->assertRedirect(route('task_statuses.index'));
        $this->get(route('task_statuses.index'))
            ->assertSee($this->request);
        $this->assertDatabaseHas('task_statuses', $this->request);
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::edit
     *
     */
    public function testEditStatus()
    {
        $this->get(route('task_statuses.edit', $this->taskStatus))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->get(route('task_statuses.edit', $this->taskStatus))
            ->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::update
     *
     */
    public function testUpdateStatus()
    {
        $this->patch(route('task_statuses.update', $this->taskStatus), $this->request)
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->patch(route('task_statuses.update', $this->taskStatus), $this->request)
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionDoesntHaveErrors();
        $this->get(route('task_statuses.index'))
            ->assertSee($this->request);
        $this->assertDatabaseHas('task_statuses', $this->request);
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::destroy
     *
     */
    public function testDestroyStatusNotAssigned()
    {
        $this->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertStatus(403);

        $this->followingRedirects()
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertOk()
            ->assertSee('Статус успешно удалён');
        $this->assertModelMissing($this->taskStatus);
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::destroy
     *
     */
    public function testDestroyStatusAssigned()
    {
        $assignedTaskStatus = $this->task->status;
        $this->assertModelExists($assignedTaskStatus);

        $this->delete(route('task_statuses.destroy', $assignedTaskStatus))
            ->assertStatus(403);

        $this->followingRedirects()
            ->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $assignedTaskStatus))
            ->assertOk()
            ->assertSee('Не удалось удалить статус');

        $this->assertModelExists($assignedTaskStatus);
    }
}
