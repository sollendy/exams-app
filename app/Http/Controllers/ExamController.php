<?php

namespace App\Http\Controllers;


use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ExamController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'exam_date' => 'required|date',
        ]);

        $exam = Exam::create([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($exam, 201);
    }

    public function userExams(Request $request)
    {
        $userExams = Exam::where('user_id', $request->user()->id)->get() ?? collect();
        
        return view("dashboard", ["esamiUtente" => $userExams]);
    }

    public function allExams(Request $request)
    {
        $query = Exam::query();

        if ($request->has('title')&& $request->title != '') {
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
