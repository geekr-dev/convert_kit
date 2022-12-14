<?php

namespace Database\Factories\Mail;

use Domain\Mail\Models\SentMail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SentMailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SentMail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sendable_id' => $this->faker->randomNumber(),
            'sendable_type' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'subscriber_id' => $this->faker->randomNumber(),
            'sent_at' => $this->faker->dateTime(),
            'opened_at' => $this->faker->dateTime(),
            'clicked_at' => $this->faker->dateTime(),
        ];
    }
}
