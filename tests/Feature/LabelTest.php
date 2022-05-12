<?php

namespace Tests\Feature;

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
}
