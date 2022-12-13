<?php

namespace Database\Factories\Mail;

use Domain\Mail\Models\Broadcast\Broadcast;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'subject' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'filters' => [
                'form_ids' => $this->faker->randomElements(range(1, 10), $this->faker->randomElement(range(1, 2))),
                'tags_ids' => $this->faker->randomElements(range(1, 100), $this->faker->randomElement(range(2, 5))),
            ],
            'status' => $this->faker->randomElement(["draft", "sent"]),
            'sent_at' => $this->faker->dateTime(),
            'user_id' => $this->faker->randomNumber(),
        ];
    }
}
