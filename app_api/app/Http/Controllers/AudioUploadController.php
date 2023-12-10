<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AudioUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:mp3'
        ]);

        $file = $request->file('audio');
        $path = $file->store('', 'nuxt_audio'); // Сохранение файла в локальном диске 'nuxt_audio'
        $fileName = basename($path); // Получение только имени файла

        return response()->json(['path' => $fileName]);
    }
}
