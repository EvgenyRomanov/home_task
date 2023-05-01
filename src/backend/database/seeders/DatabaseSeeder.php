<?php

namespace Database\Seeders;

use App\Models\Engineer;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Engineer::factory(10)->create();
        Task::factory(10)->create();
    }
}
