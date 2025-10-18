<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->whereNotIn('role', ['admin', 'supervisor'])->pluck('id');
        $exams = DB::table('exams')->pluck('id');

        foreach ($users as $user_id) {
            $assignedExams = $exams->random(rand(1, min(3, $exams->count())));

            foreach ($assignedExams as $exam_id) {
                $vote = rand(0, 1) ? rand(18, 30) : null; 

                DB::table('exams_users')->insert([
                    'exam_id' => $exam_id,
                    'user_id' => $user_id,
                    'vote' => $vote,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
