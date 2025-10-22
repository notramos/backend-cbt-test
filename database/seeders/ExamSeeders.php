<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Question;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exam = Exam::create([
            'title' => 'Ujian CBT Umum',
            'duration_minutes' => 60,
            'total_questions' => 20,
        ]);

        Question::factory()->count(50)->create(['exam_id' => $exam->id]);
    }
}
