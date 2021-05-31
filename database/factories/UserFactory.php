<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'role' => 'Subject',
            'test_chamber' => $this->faker->numberBetween(1, 5),
            'date_of_birth' => $this->faker->dateTimeBetween('-50 years', '-20 years'),
            'total_score' => $this->faker->numberBetween(60, 100),
            'alive' => true,
        ];
    }

    public function gladosUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'GLaDOS',
                'test_chamber' => null,
                'total_score' => null,
            ];
        });
    }
}
