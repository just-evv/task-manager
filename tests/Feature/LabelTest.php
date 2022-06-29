<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class LabelTest extends TestCase
{
    private Model $user;
    private array $request;
    private Model $label1;
    private Model $label2;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->createOne();
        $this->request = [
            'name' => 'Label 1',
            'description' => 'Description 1'
        ];
        $this->label1 = Label::factory()->createOne();
        $this->label2 = Label::factory()->has(Task::factory())->createOne();
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
        $this->followingRedirects()
            ->post(route('labels.store', $this->request))
            ->assertOk()
            ->assertSee($this->request);
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
        $this->followingRedirects()
            ->patch(route('labels.update', $this->label1), $this->request)
            ->assertOk()
            ->assertSessionDoesntHaveErrors()
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

        $this->followingRedirects()
            ->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label1))
            ->assertOk()
            ->assertSee('Метка успешно удалена');

        $this->assertModelMissing($this->label1);

        $this->followingRedirects()
            ->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label2))
            ->assertOk()
            ->assertSee('Не удалось удалить метку');

        $this->assertModelExists($this->label2);
    }
}
