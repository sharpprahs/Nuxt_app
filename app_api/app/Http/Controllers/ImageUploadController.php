<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,webp'
        ]);

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $destinationPath = 'tasks/img';
        $file->move(public_path($destinationPath), $fileName);

        // Возврат JSON-ответа только с именем файла
        return response()->json(['filename' => $fileName]);
    }
}
