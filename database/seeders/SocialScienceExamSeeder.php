<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;

class SocialScienceExamSeeder extends Seeder
{
    public function run()
    {
        // Buat ujian IPS
        $exam = Exam::create([
            'title' => 'Ujian Ilmu Pengetahuan Sosial (IPS)',
            'duration_minutes' => 20,
            'total_questions' => 10,
        ]);

        // 1. Soal Geografi - Teks (tidak perlu gambar)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Negara manakah yang dikenal sebagai "Negeri Tirai Bambu"?',
            'options' => ['Jepang', 'India', 'Tiongkok', 'Vietnam'],
            'correct_answer' => 'C',
            'explanation' => 'Tiongkok disebut "Negeri Tirai Bambu" karena kebijakan isolasi politik dan budayanya di masa lalu, serta penggunaan bambu sebagai simbol budaya.',
        ]);

        // 2. Soal Sejarah - Teks
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Tahun berapakah Proklamasi Kemerdekaan Indonesia?',
            'options' => ['1944', '1945', '1946', '1947'],
            'correct_answer' => 'B',
            'explanation' => 'Proklamasi Kemerdekaan Indonesia dibacakan oleh Soekarno-Hatta pada tanggal 17 Agustus 1945 di Jakarta.',
        ]);

        // 3. Soal Ekonomi - Teks
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Apa yang dimaksud dengan inflasi?',
            'options' => [
                'Penurunan nilai tukar uang',
                'Kenaikan harga barang dan jasa secara umum',
                'Peningkatan ekspor',
                'Penurunan suku bunga'
            ],
            'correct_answer' => 'B',
            'explanation' => 'Inflasi adalah kondisi kenaikan harga barang dan jasa secara umum dan terus-menerus dalam kurun waktu tertentu.',
        ]);

        // 4. Soal Geografi - Gambar (landmark: Piramida)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Bangunan bersejarah berikut terletak di negara mana?',
            'image' => 'https://picsum.photos/400/250?image=1024', // Piramida
            'options' => ['Mesir', 'Yunani', 'Irak', 'Turki'],
            'correct_answer' => 'A',
            'explanation' => 'Gambar menunjukkan Piramida Giza, salah satu dari Tujuh Keajaiban Dunia Kuno yang terletak di Mesir.',
        ]);

        // 5. Soal Budaya - Gambar (pakaian adat Jawa)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Pakaian adat pada gambar merupakan pakaian tradisional dari daerah mana di Indonesia?',
            'image' => 'https://picsum.photos/400/250?image=100', // ilustrasi kebaya & batik
            'options' => ['Jawa Tengah', 'Sumatera Barat', 'Bali', 'Papua'],
            'correct_answer' => 'A',
            'explanation' => 'Pakaian tersebut menggambarkan kebaya dan batik khas Jawa Tengah, yang sering digunakan dalam acara formal dan upacara adat.',
        ]);

        // 6. Soal Peta - Gambar (Pulau Jawa)
        // ✅ Ganti dari opsi-gambar menjadi gambar utama + opsi teks
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Peta berikut menunjukkan pulau mana di Indonesia?',
            'image' => 'https://picsum.photos/400/250?image=600', // ilustrasi bentuk Pulau Jawa
            'options' => ['Jawa', 'Sumatera', 'Kalimantan', 'Sulawesi'],
            'correct_answer' => 'A',
            'explanation' => 'Peta menunjukkan bentuk Pulau Jawa, pulau terpadat di Indonesia yang dihuni lebih dari 150 juta jiwa.',
        ]);

        // 7. Soal Sosial - Teks
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Apa fungsi utama lembaga keluarga dalam masyarakat?',
            'options' => [
                'Menghasilkan barang dan jasa',
                'Menjaga keamanan negara',
                'Mendidik anak dan meneruskan nilai budaya',
                'Mengatur sistem pemerintahan'
            ],
            'correct_answer' => 'C',
            'explanation' => 'Lembaga keluarga berperan sebagai wahana pertama dalam pendidikan moral, sosial, dan budaya bagi anak-anak.',
        ]);

        // 8. Soal Sejarah Dunia - Teks
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'text',
            'question_text' => 'Peristiwa apa yang memicu dimulainya Perang Dunia I?',
            'options' => [
                'Pengeboman Pearl Harbor',
                'Pembunuhan Archduke Franz Ferdinand',
                'Revolusi Rusia',
                'Krisis Suez'
            ],
            'correct_answer' => 'B',
            'explanation' => 'Pembunuhan Archduke Franz Ferdinand dari Austria-Hongaria pada 28 Juni 1914 di Sarajevo menjadi pemicu langsung Perang Dunia I.',
        ]);

        // 9. Soal Ekonomi - Gambar (mata uang Yen)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Mata uang berikut digunakan di negara mana?',
            'image' => 'https://picsum.photos/400/250?image=500', // ilustrasi Yen Jepang
            'options' => ['Korea Selatan', 'Jepang', 'Thailand', 'Filipina'],
            'correct_answer' => 'B',
            'explanation' => 'Gambar menunjukkan Yen, mata uang resmi Jepang yang dikeluarkan oleh Bank of Japan.',
        ]);

        // 10. Soal Geografi Indonesia - Gambar (Sungai Kapuas)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'image',
            'question_text' => 'Gambar berikut menunjukkan sungai terpanjang di Indonesia. Apa namanya?',
            'image' => 'https://picsum.photos/400/250?image=700', // ilustrasi sungai
            'options' => ['Sungai Musi', 'Sungai Kapuas', 'Sungai Bengawan Solo', 'Sungai Mahakam'],
            'correct_answer' => 'B',
            'explanation' => 'Sungai Kapuas di Kalimantan Barat adalah sungai terpanjang di Indonesia dengan panjang sekitar 1.143 km.',
        ]);

        $this->command->info("✅ Ujian IPS berhasil dibuat: 10 soal (6 teks + 4 gambar), semua soal gambar memiliki ilustrasi utama.");
    }
}
