<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class LabelTest extends TestCase
{
    private object $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @covers \App\Http\Controllers\LabelController::create
     *
     */
    public function testCreateLabel()
    {
        $this->get(route('labels.create'))
            ->assertOk();
    }

    /**
     * @covers \App\Http\Controllers\LabelController::store
     *
     */
    public function testStoreLabel()
    {
        $newLabel = ['name' => 'new label'];
        $this->post(route('labels.store', $newLabel))
            ->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $newLabel);
    }

    /**
     * @covers \App\Http\Controllers\LabelController::edit
     *
     */
    public function testEditLabel()
    {
        $label = Label::factory()->create();
        $this->get(route('labels.edit', $label))
            ->assertOk()
            ->assertSee('form');
    }

    /**
     * @covers \App\Http\Controllers\LabelController::update
     *
     */
    public function testUpdateLabel()
    {
        $label = Label::factory()->create();
        $request = ['name' => 'new name', 'description' => ''];
        $this->patch(route('labels.update', $label), $request)
            ->assertRedirect(route('labels.index'))
            ->assertSessionDoesntHaveErrors();
        $updatedLabel = Label::findOrFail($label->id);
        $this->assertEquals($request['name'], $updatedLabel->name);
    }

    /**
     * @covers \App\Http\Controllers\LabelController::destroy
     *
     */
    public function testDestroyLabel()
    {
        $label1 = Label::factory()->create();
        $this->assertModelExists($label1);
        $this->delete(route('labels.destroy', $label1))
            ->assertRedirect(route('labels.index'));
        $this->assertModelMissing($label1);

        $label2 = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach($label2);
        $task->save();
        $this->delete(route('labels.destroy', $label2))
            ->assertRedirect(route('labels.index'));
        $this->assertModelExists($label2);
    }
}
