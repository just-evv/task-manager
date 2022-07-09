<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\TaskStatusController
 * @covers \App\Policies\TaskStatusPolicy
 */
class TaskStatusTest extends TestCase
{
    private User $user;
    private array $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->request = ['name' => 'Testing Status'];
    }
    /**
     * @covers \App\Http\Controllers\TaskStatusController::index
     *
     */
    public function testIndexTaskStatus()
    {
        $this->get(route('task_statuses.index'))
            ->assertOk()
            ->assertViewIs('task_statuses.index');
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
            ->assertOk()
            ->assertViewIs('task_statuses.create');
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
        $taskStatus = TaskStatus::factory()->createOne();
        $this->get(route('task_statuses.edit', $taskStatus))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->get(route('task_statuses.edit', $taskStatus))
            ->assertOk()
            ->assertViewIs('task_statuses.edit');
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::update
     *
     */
    public function testUpdateStatus()
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

    /**
     * @covers \App\Http\Controllers\TaskStatusController::destroy
     *
     */
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

    /**
     * @covers \App\Http\Controllers\TaskStatusController::destroy
     *
     */
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
