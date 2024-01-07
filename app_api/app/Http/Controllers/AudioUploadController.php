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
        $fileName = time() . '_' . $file->getClientOriginalName();
        $destinationPath = 'tasks/audio';
        $file->move(public_path($destinationPath), $fileName);

        // Возврат JSON-ответа только с именем файла
        return response()->json(['filename' => $fileName]);
    }
}
