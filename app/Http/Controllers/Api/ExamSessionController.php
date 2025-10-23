<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Question;
use App\Models\ExamAnswer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExamSessionController extends Controller
{
    public function start($examId)
    {
        try {
            $user = Auth::user();
            $exam = Exam::findOrFail($examId);
            $existing = ExamSession::where('user_id', $user->id)
                ->where('exam_id', $exam->id)
                ->where('is_submitted', false)
                ->first();

            if ($existing) {
                if (empty($existing->question_order)) {
                    Log::warning("Sesi lama tanpa question_order → hapus dan buat baru");
                    $existing->delete();
                    $existing = null;
                }
            }
            if ($existing) {

                $questionIds = $existing->question_order;
                $questionsById = Question::whereIn('id', $questionIds)
                    ->get(['id', 'type', 'question_text', 'image', 'options'])
                    ->keyBy('id');

                $questions = collect($questionIds)->map(function ($id) use ($questionsById) {
                    return $questionsById->get($id);
                })->filter()->values();

                $session = $existing;
            } else {
                $questions = Question::where('exam_id', $exam->id)
                    ->inRandomOrder()
                    ->limit($exam->total_questions)
                    ->get(['id', 'type', 'question_text', 'image', 'options']);

                $questionIds = $questions->pluck('id')->toArray();

                $session = ExamSession::create([
                    'user_id' => $user->id,
                    'exam_id' => $exam->id,
                    'started_at' => now(),
                    'question_order' => $questionIds,
                ]);
            }

            // Format soal
            $questions->each(function ($q) {
                if ($q->image) {
                    $q->image_url = asset('storage/' . $q->image);
                }
                $options = $q->options;
                foreach ($options as $key => $value) {
                    if (is_string($value) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $value)) {
                        $options[$key] = asset('storage/' . $value);
                    }
                }
                $q->options = $options;
            });


            return response()->json([
                'session_id' => $session->id,
                'exam' => [
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'duration_minutes' => $exam->duration_minutes,
                    'total_questions' => $exam->total_questions,
                ],
                'questions' => $questions,
                'message' => $existing ? 'Sesi ujian lama dilanjutkan' : 'Sesi ujian baru dimulai',
            ], 200);
        } catch (\Exception $e) {
            Log::error("=== FATAL ERROR in start() ===", [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Gagal memulai ujian',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function submit(Request $request, $sessionId)
    {
        try {
            $session = ExamSession::with('exam')->findOrFail($sessionId);

            if ($session->is_submitted) {
                return response()->json([
                    'message' => 'Ujian sudah disubmit sebelumnya',
                ], 400);
            }

            $request->validate([
                'answers' => 'required|array|min:1',
                'answers.*.question_id' => 'required|exists:questions,id',
                'answers.*.answer' => 'required|string|in:A,B,C,D',
            ]);

            $answers = $request->input('answers');
            $correctCount = 0;
            $total = count($answers);

            // Validasi: semua soal harus milik exam ini
            $questionIds = array_column($answers, 'question_id');
            $validQuestions = Question::whereIn('id', $questionIds)
                ->where('exam_id', $session->exam_id)
                ->pluck('id')
                ->toArray();

            if (count($validQuestions) !== count($questionIds)) {
                return response()->json([
                    'message' => 'Beberapa soal tidak valid untuk ujian ini',
                ], 400);
            }

            foreach ($answers as $ans) {
                $question = Question::find($ans['question_id']);
                $isCorrect = $question->correct_answer === $ans['answer'];

                ExamAnswer::updateOrCreate(
                    ['session_id' => $session->id, 'question_id' => $ans['question_id']],
                    ['answer' => $ans['answer'], 'is_correct' => $isCorrect]
                );

                if ($isCorrect) $correctCount++;
            }

            $score = $total > 0 ? round(($correctCount / $total) * 100, 2) : 0;

            $session->update([
                'is_submitted' => true,
                'submitted_at' => now(),
                'score' => $score,
            ]);

            return response()->json([
                'message' => 'Jawaban berhasil disubmit',
                'score' => $score,
                'correct' => $correctCount,
                'total_questions' => $total,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sesi ujian tidak ditemukan',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Data jawaban tidak valid',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error("Submit error: " . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'session_id' => $sessionId,
                'answers' => $request->input('answers')
            ]);

            return response()->json([
                'message' => 'Gagal menyimpan jawaban',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function show($sessionId)
    {
        try {
            $session = ExamSession::with('exam')->findOrFail($sessionId);
            $total = $session->exam->total_questions;
            $correct = $session->answers()->where('is_correct', true)->count();
            $wrong = $total - $correct;

            return response()->json([
                'exam' => $session->exam->title,
                'score' => (float) $session->score,
                'total_questions' => $total,
                'correct' => $correct,
                'wrong' => $wrong,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sesi ujian tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil hasil ujian',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function review($sessionId)
    {
        try {
            $session = ExamSession::with(['exam', 'answers.question'])->findOrFail($sessionId);

            $results = [];
            foreach ($session->answers as $answer) {
                $question = $answer->question;
                $isCorrect = $answer->is_correct;

                $results[] = [
                    'question_id' => $question->id,
                    'question_text' => $question->question_text,
                    'options' => $question->options,
                    'correct_answer' => $question->correct_answer,
                    'user_answer' => $answer->answer,
                    'is_correct' => $isCorrect,
                    'image_url' => $question->image,
                    'explanation' => $question->explanation ?? 'Tidak ada pembahasan.',
                ];
            }

            return response()->json([
                'session_id' => $session->id,
                'exam_title' => $session->exam->title,
                'total_questions' => count($results),
                'score' => $session->score,
                'questions' => $results,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data pembahasan',
            ], 500);
        }
    }
}
