<?php

namespace Database\Factories\Mail;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Broadcast;

class BroadcastFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Broadcast::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'filters' => '{}',
            'status' => $this->faker->randomElement(["draft","published"]),
            'sent_at' => $this->faker->dateTime(),
        ];
    }
}
