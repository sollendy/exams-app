<?php

namespace Tests\Unit;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_exam_can_be_created()
    {
        $user = User::factory()->create();

        $exam = Exam::create([
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('exams', [
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function an_exam_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $exam = Exam::create([
            'title' => 'Science Exam',
            'exam_date' => '2025-11-12',
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $exam->user);
        $this->assertEquals($user->id, $exam->user->id);
    }

    /** @test */
    public function exam_title_is_required()
    {
        $user = User::factory()->create();

        $exam = new Exam([
            'exam_date' => '2025-10-10',
            'user_id' => $user->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $exam->save();
    }

    /** @test */
    public function exam_date_is_required()
    {
        $user = User::factory()->create();

        $exam = new Exam([
            'title' => 'History Exam',
            'user_id' => $user->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        $exam->save();
    }
}
