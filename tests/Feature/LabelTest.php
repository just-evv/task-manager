<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelTest extends TestCase
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
            ->get(route('labels.index'))
            ->assertSee(['Create', 'Action']);
    }

    public function testCreateLabel()
    {
        $this->get(route('labels.create'))
            ->assertOk();
    }

    public function testStoreLabel()
    {
        $newLabel = ['name' => 'new label'];
        $this->post(route('labels.store', $newLabel))
            ->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testEditLabel()
    {
        $label = Label::factory()->create();
        $this->get(route('labels.edit', $label))
            ->assertOk()
            ->assertSee('form');
    }
}
