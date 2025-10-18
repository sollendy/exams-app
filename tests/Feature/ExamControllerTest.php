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
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $data = [
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
        ];

        $response = $this->actingAs($admin)->post(route('exam.create'), $data);

        $response->assertRedirect('dashboard');
        $response->assertSessionHas('success', 'Esame creato con successo.');

        $this->assertDatabaseHas('exams', [
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
        ]);
    }

    /** @test */
    public function user_cannot_create_duplicate_exam()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        Exam::create([
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
        ]);

        $data = [
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
        ];

        $response = $this->actingAs($admin)->post(route('exam.create'), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors('exam_exists');
    }

    /** @test */
    public function user_can_view_their_exams()
    {
        $user = User::factory()->create(['role' => 'user']);

        $exam = Exam::factory()->create([
            'title' => 'Informatica',
            'exam_date' => '1981-02-09',
        ]);

        $exam->users()->attach($user->id);

        $response = $this->actingAs($user)->get(route('exam.userExams'));

        $response->assertStatus(200);
        $response->assertViewHas('esamiUtente');
        $response->assertSee($exam->title);
    }

    /** @test */
    public function user_can_filter_exams_by_title_and_date()
    {
        $user = User::factory()->create(["role" => "user"]);

        $exam1 = Exam::factory()->create([
            'title' => 'Math Exam',
            'exam_date' => '2025-10-10',
        ]);

        $exam1->users()->attach($user->id);

        $exam2 = Exam::factory()->create([
            'title' => 'Science Exam',
            'exam_date' => '2025-11-12',
        ]);

        $exam2->users()->attach($user->id);

        $response = $this->actingAs($user)->get(route('exam.userExams') . '?title=Math');

        $response->assertStatus(200);
        $response->assertSee($exam1->title);
        $response->assertDontSee($exam2->title);

        $response = $this->actingAs($user)->get(route('exam.userExams') . '?date=2025-10-10');

        $response->assertStatus(200);
        $response->assertSee($exam1->title);
        $response->assertDontSee($exam2->title);
    }


    /** @test */
    public function all_exams_are_returned_when_no_filters_are_provided()
    {
        $user = User::factory()->create();

        $exam1 = Exam::factory()->create();
        $exam2 = Exam::factory()->create();

        $response = $this->get(route('exams.index'));

        $response->assertStatus(200);
        $response->assertSee($exam1->title);
        $response->assertSee($exam2->title);
    }

    /** @test */
    public function user_can_book_exam()
    {
        $user = User::factory()->create(["role" => "user"]);
        $exam = Exam::factory()->create();

        $response = $this->actingAs($user)->post(route('exam.book', ['examId' => $exam->id, 'userId' => $user->id]));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Esame prenotato con successo! Esame: ' . $exam->title);
        $this->assertDatabaseHas('exams_users', [
            'exam_id' => $exam->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function user_cannot_book_exam_more_than_once()
    {
        $user = User::factory()->create(["role" => "user"]);
        $exam = Exam::factory()->create();

        $this->actingAs($user)->post(route('exam.book', ['examId' => $exam->id, 'userId' => $user->id]));

        $response = $this->actingAs($user)->post(route('exam.book', ['examId' => $exam->id, 'userId' => $user->id]));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Hai già prenotato questo esame.');
    }
}
