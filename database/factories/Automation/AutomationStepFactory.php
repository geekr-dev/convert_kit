<?php

namespace Database\Factories\Automation;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AutomationStep;

class AutomationStepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AutomationStep::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'automation_id' => $this->faker->randomNumber(),
            'type' => $this->faker->randomElement(["type","action"]),
            'name' => $this->faker->name,
            'value' => '{}',
        ];
    }
}
