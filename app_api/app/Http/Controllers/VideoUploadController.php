<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4'
        ]);

        $file = $request->file('video');
        $path = $file->store('', 'nuxt_video'); // Сохраняет файл в локальном диске 'nuxt_video'
        $fileName = basename($path); // Получаем только имя файла

        return response()->json(['path' => $fileName]);
    }
}
