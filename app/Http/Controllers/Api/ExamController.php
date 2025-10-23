<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamSession;

class ExamController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json(['message' => 'Tidak terautentikasi'], 401);
            }

            $exams = Exam::select('id', 'title', 'duration_minutes', 'total_questions')->get();
            $sessions = ExamSession::with('exam:id,title')
                ->where('user_id', $userId)
                ->orderBy('started_at', 'desc')
                ->get();

            $sessionsByExam = $sessions->groupBy('exam_id');

            $examsWithHistory = $exams->map(function ($exam) use ($sessionsByExam) {
                $history = $sessionsByExam->get($exam->id, collect())->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'score' => $session->score ?? 0,
                        'started_at' => $session->started_at?->format('d M Y - H:i'),
                        'ended_at' => $session->submitted_at?->format('d M Y - H:i'),
                        'is_submitted' => $session->is_submitted,
                    ];
                });

                return [
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'total_questions' => $exam->total_questions,
                    'duration_minutes' => $exam->duration_minutes,
                    'history' => $history,
                ];
            });

            return response()->json([
                'exams' => $examsWithHistory,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
