<?php

namespace App\Http\Controllers;


use App\Models\Transcript;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TranscriptController extends Controller
{
    public function assignVote(Request $request, $userId, $examId)
    {
        $request->validate([
            'vote' => 'required|integer|min:1|max:10',
        ]);

        $transcript = Transcript::updateOrCreate(
            ['user_id' => $userId, 'exam_id' => $examId],
            ['vote' => $request->vote]
        );

        return response()->json($transcript, 200);
    }
}
