<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        // Получите записи из таблицы "posts"
        $posts = Post::all();

        // Верните записи в формате JSON
        return response()->json($posts);
    }
}
