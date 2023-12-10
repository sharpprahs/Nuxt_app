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
        $path = $file->store('', 'nuxt_img'); // Сохранение файла в локальном диске 'nuxt_images'
        $fileName = basename($path); // Получение только имени файла

        return response()->json(['path' => $fileName]);
    }
}
