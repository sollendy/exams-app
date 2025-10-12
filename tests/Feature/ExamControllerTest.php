<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ExamControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_exam()
    {
        $user = User::factory()->create();

        $data = [
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
        ];

        $response = $this->actingAs($user)->withoutMiddleware("checkRole")->postJson('exam/create-exam', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('exams', [
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
        ]);
    }

    /** @test */
    public function user_can_view_their_exams()
    {
        $user = User::factory()->create();
        $exam = Exam::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->withoutMiddleware("checkRole")->getJson('exam/user-exams');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $exam->id,
            'title' => $exam->title,
        ]);
    }

    /** @test */
    public function user_can_filter_exams_by_title_and_date()
    {
        $exam1 = Exam::factory()->create([
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
        ]);
        $exam2 = Exam::factory()->create([
            'title' => 'Science Exam',
            'exam_date' => '2025-11-12',
        ]);

        $response = $this->getJson('/?title=Math');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $exam1->id,
            'title' => $exam1->title,
        ]);
        $response->assertJsonMissing([
            'id' => $exam2->id,
            'title' => $exam2->title,
        ]);

        $response = $this->getJson('/?date=2025-10-10');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $exam1->id,
            'title' => $exam1->title,
        ]);
        $response->assertJsonMissing([
            'id' => $exam2->id,
            'title' => $exam2->title,
        ]);
    }

    /** @test */
    public function all_exams_are_returned_when_no_filters_are_provided()
    {
        $exam1 = Exam::factory()->create();
        $exam2 = Exam::factory()->create();

        $response = $this->getJson('/all-exams');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $exam1->id,
            'title' => $exam1->title,
        ]);
        $response->assertJsonFragment([
            'id' => $exam2->id,
            'title' => $exam2->title,
        ]);
    }
}
