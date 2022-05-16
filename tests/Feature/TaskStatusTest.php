<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    private object $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testSeeAsUser()
    {
        $this->actingAs($this->user)
            ->get(route('task_statuses.index'))
            ->assertSee(['Create', 'Action']);
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::create
     *
     */
    public function testCreateStatus()
    {
        $this->get(route('task_statuses.create'))
            ->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::store
     *
     */
    public function testStoreStatus()
    {
        $newStatus = ['name' => 'testing status'];
        $this->post(route('task_statuses.store', $newStatus))
            ->assertRedirect(route('task_statuses.index'));
        $this->get(route('task_statuses.index'))
            ->assertSee($newStatus);
        $this->assertDatabaseHas('task_statuses', $newStatus);
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::edit
     *
     */
    public function testEditStatus()
    {
        $status = TaskStatus::factory()->create();
        $this->get(route('task_statuses.edit', $status))
            ->assertOk()
            ->assertSee('form');
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::update
     *
     */
    public function testUpdateStatus()
    {
        $status = TaskStatus::factory()->create();
        $request = ['name' => 'new status'];
        $this->patch(route('task_statuses.update', $status), $request)
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionDoesntHaveErrors();
        $updatedStatus = DB::table('task_statuses')->find($status->id);
        $this->assertEquals($request['name'], $updatedStatus->name);
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::destroy
     *
     */
    public function testDestroyStatusNotAssigned()
    {
        $status = TaskStatus::factory()->create();
        $this->assertModelExists($status);
        $statusId = $status->id;
        $this->assertDatabaseHas('task_statuses', ['id' => $statusId]);

        $this->delete(route('task_statuses.destroy', $status))
            ->assertredirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', ['id' => $statusId]);
    }

    /**
     * @covers \App\Http\Controllers\TaskStatusController::destroy
     *
     */
    public function testDestroyStatusAssigned()
    {
        $task = Task::factory()->create();
        $status = $task->status;
        $this->assertModelExists($status);

        $this->delete(route('task_statuses.destroy', $status))
            ->assertredirect(route('task_statuses.index'));
        $this->assertModelExists($status);
    }
}
