<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->sentence(5),
            'type' => 'text',
            'options' => null,
        ];
    }

    public function selectQuestion()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'select',
                'options' => [
                    [
                        'label' => $this->faker->words(3, true),
                        'value' => 'A'
                    ],
                    [
                        'label' => $this->faker->words(3, true),
                        'value' => 'B'
                    ],
                    [
                        'label' => $this->faker->words(3, true),
                        'value' => 'C'
                    ],
                    [
                        'label' => $this->faker->words(3, true),
                        'value' => 'D'
                    ],
                ],
            ];
        });
    }
}
