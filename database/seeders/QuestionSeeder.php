<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use Faker\Factory as Faker;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exam_id = 2; // Asumsikan kita menambahkan pertanyaan ke ujian dengan ID 1
        $faker = Faker::create();

        // 15 soal multiple choice biasa
        for ($i = 1; $i <= 15; $i++) {
            Question::create([
                'exam_id' => $exam_id, // sementara 1, nanti bisa disesuaikan
                'type' => 'multiple_choice',
                'question_text' => $faker->sentence(10),
                'options' => [
                    'A' => $faker->word(),
                    'B' => $faker->word(),
                    'C' => $faker->word(),
                    'D' => $faker->word(),
                ],
                'correct_answer' => $faker->randomElement(['A', 'B', 'C', 'D']),
                'explanation' => $faker->sentence(15),
            ]);
        }

        // 5 soal bergambar
        for ($i = 1; $i <= 5; $i++) {
            Question::create([
                'exam_id' => $exam_id, // sementara 1, nanti bisa disesuaikan
                'type' => 'bergambar',
                'question_text' => 'Perhatikan gambar berikut, lalu pilih jawaban yang benar:',
                'image' => 'https://picsum.photos/seed/' . uniqid() . '/400/300',
                'options' => [
                    'A' => $faker->word(),
                    'B' => $faker->word(),
                    'C' => $faker->word(),
                    'D' => $faker->word(),
                ],
                'correct_answer' => $faker->randomElement(['A', 'B', 'C', 'D']),
                'explanation' => $faker->sentence(20),
            ]);
        }
    }
}
