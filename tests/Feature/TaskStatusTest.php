<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testSeeder()
    {
        $this->assertDatabaseHas('task_statuses', ['name' => 'new']);
    }
}
