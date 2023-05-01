<?php

namespace Database\Factories;

use App\Models\Engineer;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class EngineerFactory extends Factory
{
    protected $model = Engineer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'surname'  => $this->faker->lastName,
            'phone' => null,
            'email' => $this->faker->email
        ];
    }
}
