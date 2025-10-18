<?php

namespace App\Http\Controllers;


use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    public function showCreateForm()
    {
        return view('exams.create_exams');
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
        ]);

        $existingExam = Exam::where('title', $request->title)
            ->whereDate('exam_date', $request->exam_date)
            ->first();

        if ($existingExam) {
            return back()->withErrors(['exam_exists' => 'L\'esame esiste già con la stessa data.'])->withInput();
        }

        $exam = Exam::create([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
        ]);

        return redirect('dashboard')->with('success', 'Esame creato con successo e assegnato all\'utente.');
    }

    public function showExamUsers($examId)
    {
        $exam = Exam::findOrFail($examId);

        $users = $exam->users;

        return view('exams.exam_users_list', compact('exam', 'users'));
    }

    public function userBookExam(Request $request, $userId, $examId)
    {
        $user = User::findOrFail($userId);

        $exam = Exam::findOrFail($examId);

        $alreadyBooked = $user->exams()->where('exam_id', $examId)->exists();

        if ($alreadyBooked) {
            Log::info("sono dentro already booked");
            return back()->with(['error' => 'L\'utente ha già prenotato questo esame.'], 400);
        }
        Log::info("sono uscito da already booked");
        $user->exams()->attach($examId, ['vote' => 0]);

        Log::info("sono alla fine del dannato controller");
        return back()->with('success', 'Esame prenotato con successo! Esame: ' . $exam->title);
    }

    public function getDashboardExams(Request $request)
    {
        $query = Exam::query();

        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('exam_date', $request->date);
        }

        $dasboardExams = $query->orderBy('exam_date')->get() ?? collect();

        return view("dashboard", ["esamiDashboard" => $dasboardExams]);
    }

    public function getUserExams(Request $request)
    {
        $query = Auth::user()->exams();

        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('exam_date', $request->date);
        }

        $userExams = $query->orderBy('exam_date')->get();
        return view('exams.user_exams', ['esamiUtente' => $userExams]);
    }

    public function allExams(Request $request)
    {
        $query = Exam::query();

        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('exam_date', $request->date);
        }

        $exams = $query->orderBy('exam_date')->get();

        // return response()->json($exams, 200);
        return view("welcome", ["esami" => $exams]);
    }
}
