<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;

class ImageBasedNaturalScienceExamSeeder extends Seeder
{
    public function run()
    {
        $exam = Exam::create([
            'title' => 'Ujian IPA - Soal Bergambar',
            'duration_minutes' => 25,
            'total_questions' => 5,
        ]);

        // 1. Fotosintesis
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Gambar berikut menunjukkan bagian tumbuhan yang mengandung klorofil. Apa fungsinya?',
            'image' => 'https://picsum.photos/400/300?random=101',
            'options' => [
                'A' => 'Menyerap air dari tanah',
                'B' => 'Melindungi dari hama',
                'C' => 'Menangkap cahaya untuk fotosintesis',
                'D' => 'Mengangkut nutrisi'
            ],
            'correct_answer' => 'C',
            'explanation' => 'Daun mengandung klorofil yang menangkap cahaya matahari untuk fotosintesis.',
        ]);

        // 2. Gaya (Newton)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Alat pada gambar digunakan untuk mengukur gaya. Apa satuannya?',
            'image' => 'https://picsum.photos/400/300?random=102',
            'options' => [
                'A' => 'Joule',
                'B' => 'Watt',
                'C' => 'Newton',
                'D' => 'Pascal'
            ],
            'correct_answer' => 'C',
            'explanation' => 'Gaya diukur dalam satuan Newton (N).',
        ]);

        // 3. pH Netral
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Gambar menunjukkan alat ukur pH. Nilai berapa yang bersifat netral?',
            'image' => 'https://picsum.photos/400/300?random=103',
            'options' => [
                'A' => '0',
                'B' => '5',
                'C' => '7',
                'D' => '14'
            ],
            'correct_answer' => 'C',
            'explanation' => 'pH 7 adalah netral, seperti air murni.',
        ]);

        // 4. Daur Ulang
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Simbol pada gambar berkaitan dengan kegiatan apa?',
            'image' => 'https://picsum.photos/400/300?random=104',
            'options' => [
                'A' => 'Membuang sampah',
                'B' => 'Daur ulang',
                'C' => 'Membakar plastik',
                'D' => 'Menimbun sampah'
            ],
            'correct_answer' => 'B',
            'explanation' => 'Simbol tiga panah melingkar adalah lambang daur ulang.',
        ]);

        // 5. Organ Ginjal
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Organ pada gambar berfungsi menyaring darah. Apa namanya?',
            'image' => 'https://picsum.photos/400/300?random=105',
            'options' => [
                'A' => 'Jantung',
                'B' => 'Hati',
                'C' => 'Paru-paru',
                'D' => 'Ginjal'
            ],
            'correct_answer' => 'D',
            'explanation' => 'Ginjal menyaring darah dan menghasilkan urine.',
        ]);

        $this->command->info("✅ Ujian IPA Bergambar (kolom 'image') berhasil dibuat: 5 soal.");
    }
}
