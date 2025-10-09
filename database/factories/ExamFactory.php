<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Exam::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'exam_date' => $this->faker->date(),
            'vote' => $this->faker->randomFloat(2, 18, 30),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
