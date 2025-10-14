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
        $users = User::where('role', 'user')->get();

        return view('exams.create_exams', compact('users'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $existingExam = Exam::where('user_id', $request->user_id)
            ->where('title', $request->title)
            ->whereDate('exam_date', $request->exam_date)
            ->first();

        if ($existingExam) {
            return back()->withErrors(['exam_exists' => 'L\'utente ha già sostenuto questo esame con la stessa data.'])->withInput();
        }

        $exam = Exam::create([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'user_id' => $request->user_id,
        ]);

        return redirect('dashboard')->with('success', 'Esame creato con successo e assegnato all\'utente.');
    }


    public function getDashboardExams(Request $request)
    {
        if (Auth::user()->role == "user") {
            $query = Exam::where('user_id', $request->user()->id);
        } else {
            $query = Exam::query();
        }

        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('exam_date', $request->date);
        }

        $dasboardExams = $query->orderBy('exam_date')->get() ?? collect();

        return view("dashboard", ["esamiDashboard" => $dasboardExams]);
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

        $exams = $query->with("user")->orderBy('exam_date')->get();

        // return response()->json($exams, 200);
        return view("welcome", ["esami" => $exams]);
    }
}
