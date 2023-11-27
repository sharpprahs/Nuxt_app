<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExercisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exercises')->insert([
            [
                'id_lang_task' => 1,
                'id_lang_answer' => 2,
                'id_section' => 1,
                'name' => 'Present simple',
                'number_task' => 1,
                'type' => 'img',
                'content_name' => 'simple.png',
                'description' => 'Опишите что на картинке',
                'true_answer' => 'send',
                'true_keywords' => 'send,sent'
            ]
        ]);
    }
}
