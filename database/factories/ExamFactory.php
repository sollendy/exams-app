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
       $exams = ["Matematica", "Italiano", "Storia", "Fisica", "Chimica", "Biologia", "Informatica", "Filosofia"];

       return [
            'title' => $exams[rand(0, (count($exams) - 1))],
            'exam_date' => $this->faker->date(),
        ];
    }
}
