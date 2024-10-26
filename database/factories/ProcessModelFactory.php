<?php

namespace Database\Factories;

use App\Models\ProcessModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProcessModelFactory extends Factory
{
    protected $model = ProcessModel::class;

    public function definition()
    {
        return [
            'process' => Str::random(10), // Generates a random string of 10 characters
        ];
    }
}
