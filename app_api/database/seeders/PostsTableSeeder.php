<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Удалите существующие записи, если они есть
        // Удалите существующие записи, если они есть
        Post::truncate();
        $data = [
            [
                'title' => 'Заголовок 1',
                'text' => 'Текст 1',
            ],
            [
                'title' => 'Заголовок 2',
                'text' => 'Текст 2',
            ],
            [
                'title' => 'Заголовок 3',
                'text' => 'Текст 3',
            ],
            [
                'title' => 'Заголовок 4',
                'text' => 'Текст 4',
            ],
            [
                'title' => 'Заголовок 5',
                'text' => 'Текст 5',
            ],
        ];

        // Вставьте данные в таблицу "posts"
        foreach ($data as $item) {
            Post::create($item);
        }
    }
}
