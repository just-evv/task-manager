<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

    /**
     * @covers \App\Http\Controllers\TaskController::index
     *
     */
    public function testTasksIndex()
    {
        $this->get(route('tasks.index'))
            ->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\TaskController::create
     *
     */
    public function testCreateTask()
    {
        $this->get(route('tasks.create'))
            ->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\TaskController::store
     *
     */
    public function testStoreTask()
    {
        $assignedUser = User::factory()->create();
        $label = Label::factory()->create();
        $newTask = [
            'name' => 'Task 1',
            'description' => 'description',
            'status_id' => $this->taskStatus->id,
            'assigned_to_id' => $assignedUser->id,
            //'labels' => [$label->id]
        ];
        $this->actingAs($this->user)
            ->post(route('tasks.store', $newTask))
            ->assertRedirect(route('tasks.index'));
        $this->get(route('tasks.index'))
            ->assertSee($newTask['name']);
        $this->assertDatabaseCount('tasks', 1);
    }

    /**
     * @covers \App\Http\Controllers\TaskController::show
     *
     */
    public function testShowTask()
    {
        $task = Task::factory()->create();
        $this->get(route('tasks.show', $task))
            ->assertSee([$task->name, $task->description, $task->status->name]);
    }

    /**
     * @covers \App\Http\Controllers\TaskController::update
     *
     */
    public function testUpdateTask()
    {
        $task = Task::factory()->create();
        $request = ['name' => 'new task',
            'description' => '',
            'status_id' => $task->status->id,
            'assigned_to_id' => $this->user->id,
            ];
        $this->patch(route('tasks.update', $task), $request)
            ->assertRedirect(route('tasks.index'))
            ->assertSessionDoesntHaveErrors();
        $updatedTask = DB::table('tasks')->find($task->id);
        $this->assertEquals($request['name'], $updatedTask->name);
    }

    /**
     * @covers \App\Http\Controllers\TaskController::destroy
     *
     */
    public function testDestroyTask()
    {
        $task = Task::factory()->create();
        $this->assertModelExists($task);
        $this->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'));
        $this->assertModelMissing($task);
    }
}
