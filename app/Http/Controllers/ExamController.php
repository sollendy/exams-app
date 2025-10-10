<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware("role:admin")->only("create");
        $this->middleware('auth')->only('userExams');
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'exam_date' => 'required|date',
        ]);

        $exam = Exam::create($request->only('title', 'exam_date'));

        return response()->json($exam, 201);
    }

    public function userExams(Request $request)
    {
        $exams = $request->user()->exams;
        return response()->json($exams, 200);
    }

    public function listExams(Request $request)
    {
        $query = Exam::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('date')) {
            $query->whereDate('exam_date', $request->date);
        }

        $exams = $query->orderBy('exam_date')->get();

        return response()->json($exams, 200);
    }
}
