<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @property Model|Task $task
 */
class TaskTest extends TestCase
{
    private Model $user;
    private Model $task;
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
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('tasks.create'))
            ->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\TaskController::store
     *
     */
    public function testStoreTask()
    {
        $this->actingAs($this->user)
            ->post(route('tasks.store', $this->request))
            ->assertRedirect(route('tasks.index'));
        $this->get(route('tasks.index'))
            ->assertSee([$this->request['name']]);
        $this->assertDatabaseHas('tasks', $this->request);
    }

    /**
     * @covers \App\Http\Controllers\TaskController::show
     *
     */
    public function testShowTask()
    {
        $this->get(route('tasks.show', $this->task))
            ->assertSee([$this->task->name]);
    }

    /**
     * @covers \App\Http\Controllers\TaskController::update
     *
     */
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

    /**
     * @covers \App\Http\Controllers\TaskController::destroy
     *
     */
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
