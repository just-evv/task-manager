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
    private object $label1;
    private object $label2;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->request = [
            'name' => 'Label 1',
            'description' => 'Description 1'
        ];
        $this->label1 = Label::factory()->create();
        $this->label2 = Label::factory()->has(Task::factory())->create();
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
        $this->get(route('labels.edit', $this->label1))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->get(route('labels.edit', $this->label1))
            ->assertOk()
            ->assertSee($this->label1['name']);
    }

    /**
     * @covers \App\Http\Controllers\LabelController::update
     *
     */
    public function testUpdateLabel()
    {
        $this->patch(route('labels.update', $this->label1), $this->request)
            ->assertRedirect(route('labels.index'))
            ->assertSessionDoesntHaveErrors();
        $updatedLabel = Label::findOrFail($this->label1['id']);
        $this->assertEquals($this->request['name'], $updatedLabel['name']);
    }

    /**
     * @covers \App\Http\Controllers\LabelController::destroy
     *
     */
    public function testDestroyLabel()
    {
        $this->delete(route('labels.destroy', $this->label1))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label1))
            ->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', $this->label1->toArray());

        $this->delete(route('labels.destroy', $this->label2))
            ->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $this->label2->toArray());
    }
}
