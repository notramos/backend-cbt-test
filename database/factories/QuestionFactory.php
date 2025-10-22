<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = $this->faker;
        $type = $this->faker->randomElement(['text', 'image']);


        $options = [];
        $correctKey = 'A';

        if ($type === 'image') {

            $options = [
                'A' => 'options/obj_a.jpg',
                'B' => 'options/obj_b.jpg',
                'C' => 'options/obj_c.jpg',
                'D' => 'options/obj_d.jpg',
            ];
            $correctKey = $this->faker->randomElement(['A', 'B', 'C', 'D']);

            return [
                'exam_id' => 1,
                'type' => 'image',
                'question_text' => 'Pilih gambar yang benar berdasarkan pernyataan berikut: ...',
                'image' => 'questions/soal_gambar.jpg', // opsional: soal utama pakai gambar
                'options' => json_encode($options),
                'correct_answer' => $correctKey,
            ];
        }


        $options = [
            'A' => $faker->word(),
            'B' => $faker->word(),
            'C' => $faker->word(),
            'D' => $faker->word(),
        ];
        $correctKey = array_rand($options);

        return [
            'exam_id' => 1,
            'type' => 'text',
            'question_text' => "Soal ke-" . $faker->unique()->numberBetween(1, 1000) . ": " . $faker->sentence(8),
            'image' => null,
            'options' => json_encode($options),
            'correct_answer' => $correctKey,
        ];
    }
}
