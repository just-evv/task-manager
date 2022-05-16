<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('labels')->insert([
            ['name' => 'bug'],
            ['name' => 'documentation'],
            ['name' => 'duplicate'],
            ['name' => 'enhancement'],
            ['name' => 'help wanted'],
            ['name' => 'invalid'],
            ['name' => 'question']
        ]);
    }
}
