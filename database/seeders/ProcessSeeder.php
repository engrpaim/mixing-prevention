<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProcessModel;

class ProcessSeeder extends Seeder
{
    public function run()
    {
        // Create 10 random processes
        ProcessModel::factory()->count(15)->create();
    }
}
