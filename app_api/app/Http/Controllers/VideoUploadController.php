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
        $fileName = time() . '_' . $file->getClientOriginalName();
        $destinationPath = 'tasks/video';
        $file->move(public_path($destinationPath), $fileName);

        // Возврат JSON-ответа только с именем файла
        return response()->json(['filename' => $fileName]);
    }
}
