<?php

namespace App\Http\Controllers;


use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function userBookExam(Request $request, $examId)
    {
        $exam = Exam::findOrFail($examId);

        if ($exam->exam_date < now()) {
            return back()->with('error', 'Non è possibile associarsi ad un esame con data passata.');
        }

        if (Auth::user()->exams()->where('exam_id', $exam->id)->exists()) {
            return back()->with('error', 'Sei già iscritto a questo esame.');
        }

        Auth::user()->exams()->attach($exam->id);

        return back()->with('success', 'Esame prenotato correttamente.');
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
