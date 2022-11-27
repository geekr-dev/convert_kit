<?php

namespace Database\Factories\Mail;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SequenceMail;

class SequenceMailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SequenceMail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'status' => $this->faker->randomElement(["draft","published"]),
            'content' => $this->faker->paragraphs(3, true),
            'filters' => '{}',
            'sequence_id' => $this->faker->randomNumber(),
            'schedule_id' => $this->faker->randomNumber(),
        ];
    }
}
