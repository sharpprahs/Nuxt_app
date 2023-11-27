<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Language;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all(['id', 'name', 'code']);
        return response()->json($languages, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $language = Language::find($id);

        if (!$language) {
            return response()->json(['message' => 'Язык не найден'], Response::HTTP_NOT_FOUND);
        }

        // Удаляем или обновляем связанные записи в таблице exercises
        // где язык используется как id_lang_task
        Exercise::where('id_lang_task', $id)->delete(); // или обновляем, если нужно

        // где язык используется как id_lang_answer
        Exercise::where('id_lang_answer', $id)->delete(); // или обновляем, если нужно

        $language->delete();

        return response()->json(['message' => 'Язык успешно удален'], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages'
        ]);

        $language = Language::create($validatedData);

        return response()->json($language, Response::HTTP_CREATED);
    }
}
