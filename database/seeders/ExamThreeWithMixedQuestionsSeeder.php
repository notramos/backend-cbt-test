<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;

class ExamThreeWithMixedQuestionsSeeder extends Seeder
{
    public function run()
    {
        // Buat ujian ketiga
        $exam = Exam::create([
            'title' => 'Ujian Campuran: Teks & Gambar (Dengan Penjelasan)',
            'duration_minutes' => 15,
            'total_questions' => 5,
        ]);

        // Soal 1: Teks
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Apa ibu kota Indonesia?',
            'options' => ['Jakarta', 'Bandung', 'Surabaya', 'Medan'],
            'correct_answer' => 'A',
            'explanation' => 'Jakarta ditetapkan sebagai ibu kota Indonesia sejak Proklamasi Kemerdekaan pada 17 Agustus 1945.',
        ]);

        // Soal 2: Teks
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Berapa hasil dari 15 + 27?',
            'options' => ['40', '42', '44', '46'],
            'correct_answer' => 'B',
            'explanation' => '15 + 27 = 42. Operasi penjumlahan dasar ini menghasilkan angka empat puluh dua.',
        ]);

        // Soal 3: Gambar (opsi berupa gambar)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Gambar berikut menunjukkan hewan apa?',
            'image' => null, // tidak ada gambar utama, soal ada di opsi
            'options' => [
                'https://picsum.photos/200/150?image=10',   // kucing
                'https://picsum.photos/200/150?image=20',   // anjing
                'https://picsum.photos/200/150?image=30',   // burung
                'https://picsum.photos/200/150?image=40',   // ikan
            ],
            'correct_answer' => 'A',
            'explanation' => 'Gambar pertama menunjukkan kucing, hewan karnivora yang sering dipelihara sebagai hewan peliharaan. Ciri khasnya termasuk bulu lembut, kumis panjang, dan kemampuan berburu tikus.',
        ]);

        // Soal 4: Gambar (ada gambar utama + opsi teks)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Bangunan berikut terletak di negara mana?',
            'image' => 'https://picsum.photos/400/250?image=100', // gambar landmark
            'options' => [
                'Prancis',
                'Italia',
                'Spanyol',
                'Portugal',
            ],
            'correct_answer' => 'A',
            'explanation' => 'Gambar menunjukkan Menara Eiffel, salah satu ikon paling terkenal di dunia yang terletak di Paris, Prancis. Menara ini dibangun pada tahun 1889 sebagai pintu gerbang Pameran Dunia.',
        ]);

        // Soal 5: Teks
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Apa singkatan dari CPU?',
            'options' => [
                'Central Processing Unit',
                'Computer Processing Unit',
                'Central Process Unit',
                'Control Processing Unit'
            ],
            'correct_answer' => 'A',
            'explanation' => 'CPU adalah Central Processing Unit, komponen utama dalam komputer yang bertugas memproses instruksi dan menjalankan program.',
        ]);

        $this->command->info("✅ Ujian ketiga berhasil dibuat dengan 5 soal (3 teks, 2 gambar) + penjelasan.");
    }
}
