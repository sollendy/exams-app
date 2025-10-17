<?php

namespace App\Http\Controllers;


use App\Models\Transcript;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TranscriptController extends Controller
{
    public function assignVote(Request $request, $userId, $examId)
    {
        $user = User::find($userId);
        if (!$user || $user->role !== 'user') {
            return response()->json(['error' => 'Utente non valido.'], 400);
        }

        $exam = $user->exams()->wherePivot('exam_id', $examId)->first();
        if (!$exam) {
            return response()->json(['error' => 'L\'utente non ha prenotato questo esame.'], 400);
        }

        $request->validate([
            'vote' => 'required|integer|min:1|max:10',
        ]);

        $user->exams()->updateExistingPivot($examId, ['vote' => $request->vote]);

        return redirect()->back()->with('success', 'Voto assegnato con successo!');
    }
}
