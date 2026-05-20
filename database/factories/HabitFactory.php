<?php

namespace Database\Factories;

use App\Models\Habit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Habit>
 */
class HabitFactory extends Factory
{
    private const HABIT_NAMES = [
        'Ler',
        'Estudar',
        'Treinar',
        'Meditar',
        'Beber água',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->unique()->randomElement(self::HABIT_NAMES),
        ];
    }
}
