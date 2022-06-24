<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class LabelTest extends TestCase
{
    private object $user;
    private array $request;
    private object $label;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->request = [
            'name' => 'Label 1',
            'description' => 'Description 1'
        ];
        $this->label = Label::factory()->create();
    }

    /**
     * @covers \App\Http\Controllers\LabelController::create
     *
     */
    public function testCreateLabel()
    {
        $this->get(route('labels.create'))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->get(route('labels.create'))
            ->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\LabelController::store
     *
     */
    public function testStoreLabel()
    {
        $this->post(route('labels.store', $this->request))
            ->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $this->request);
    }

    /**
     * @covers \App\Http\Controllers\LabelController::edit
     *
     */
    public function testEditLabel()
    {
        $this->get(route('labels.edit', $this->label))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->get(route('labels.edit', $this->label))
            ->assertOk()
            ->assertSee($this->label->name);
    }

    /**
     * @covers \App\Http\Controllers\LabelController::update
     *
     */
    public function testUpdateLabel()
    {
        $this->patch(route('labels.update', $this->label), $this->request)
            ->assertRedirect(route('labels.index'))
            ->assertSessionDoesntHaveErrors();
        $updatedLabel = Label::findOrFail($this->label->id);
        $this->assertEquals($this->request['name'], $updatedLabel->name);
    }

    /**
     * @covers \App\Http\Controllers\LabelController::destroy
     *
     */
    public function testDestroyLabel()
    {
        $this->delete(route('labels.destroy', $this->label))
            ->assertRedirect(route('labels.index'));
        $this->assertModelMissing($this->label);

        $label2 = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach($label2);
        $task->save();
        $this->delete(route('labels.destroy', $label2))
            ->assertRedirect(route('labels.index'));
        $this->assertModelExists($label2);
    }
}
