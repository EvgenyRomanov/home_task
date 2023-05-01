<?php

namespace Database\Factories;

use App\Models\Engineer;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text,
            'status_id'  => 1,
            'engineer_id' => Engineer::get()->random()->id,
        ];
    }
}
