<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

/**
 * @covers \App\Models\Label
 * @covers \App\Http\Controllers\LabelController
 * @covers \App\Policies\LabelPolicy
 */
class LabelTest extends TestCase
{
    private Model $user;
    private array $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->createOne();
        $this->request = [
            'name' => 'Label 1',
            'description' => 'Description 1'
        ];
    }

    public function testIndexLabel()
    {
        $this->get(route('labels.index'))
            ->assertOk();
    }

    public function testCreateLabel()
    {
        $this->get(route('labels.create'))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->get(route('labels.create'))
            ->assertOk();
    }

    public function testStoreLabel()
    {
        $this->post(route('labels.store', $this->request))
            ->assertStatus(403);
        $this->followingRedirects()
            ->actingAs($this->user)
            ->post(route('labels.store', $this->request))
            ->assertOk()
            ->assertSee($this->request);
        $this->assertDatabaseHas('labels', $this->request);
    }

    public function testEditLabel()
    {
        $label = Label::factory()->createOne();
        $this->get(route('labels.edit', $label))
            ->assertStatus(403);
        $this->actingAs($this->user)
            ->get(route('labels.edit', $label))
            ->assertOk();
    }


    public function testUpdateLabel()
    {
        $label = Label::factory()->createOne();
        $this->patch(route('labels.update', $label), $this->request)
            ->assertStatus(403);

        $this->followingRedirects()
            ->actingAs($this->user)
            ->patch(route('labels.update', $label), $this->request)
            ->assertOk()
            ->assertSessionDoesntHaveErrors()
            ->assertSee($this->request);
    }

    public function testDestroyLabel()
    {
        $label1 = Label::factory()->createOne();
        $this->delete(route('labels.destroy', $label1))
            ->assertStatus(403);

        $this->followingRedirects()
            ->actingAs($this->user)
            ->delete(route('labels.destroy', $label1))
            ->assertOk()
            ->assertSee('Метка успешно удалена');
        $this->assertModelMissing($label1);

        $label2 = Label::factory()->has(Task::factory())->createOne();
        $this->followingRedirects()
            ->actingAs($this->user)
            ->delete(route('labels.destroy', $label2))
            ->assertOk()
            ->assertSee('Не удалось удалить метку');

        $this->assertModelExists($label2);
    }
}
