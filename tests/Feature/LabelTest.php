<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class LabelTest extends TestCase
{
    private model $user;
    private array $request;
    private model $label1;
    private model $label2;

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
            ->assertOk();
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
        $this->get(route('labels.index'))
            ->assertSee($this->request);
    }

    /**
     * @covers \App\Http\Controllers\LabelController::destroy
     *
     */
    public function testDestroyLabel()
    {
        $this->delete(route('labels.destroy', $this->label1))
            ->assertStatus(403);
/*
        $label = new Label(['name' => 'name 1']);
        $label->save();
        $name = $label->name;
*/      $lab1Arr = $this->label1->toArray();
        $name = $lab1Arr['name'];
        $this->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label1))
            ->assertRedirect(route('labels.index'));
        $this->get(route('labels.index'))
            ->assertDontSee($name);
        $this->assertModelMissing($this->label1);

        $this->followingRedirects()
            ->delete(route('labels.destroy', $this->label2))
            ->assertOk()
            ->assertSee('Не удалось удалить метку');
    }
}
