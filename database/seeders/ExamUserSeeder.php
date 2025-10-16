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
        // Prendi tutti gli utenti e tutti gli esami
        $users = DB::table('users')->whereNotIn('role', ['admin', 'supervisor']) ->pluck('id');
        $exams = DB::table('exams')->pluck('id');

        foreach ($users as $user_id) {
            // Assegna 1-3 esami random per utente
            $assignedExams = $exams->random(rand(1, min(3, $exams->count())));

            foreach ($assignedExams as $exam_id) {
                DB::table('exams_users')->insert([
                    'exam_id' => $exam_id,
                    'user_id' => $user_id,
                    'vote' => rand(10, 30), // voto casuale tra 18 e 30
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
