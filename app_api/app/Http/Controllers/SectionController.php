<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Section;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all(['id', 'name', 'code']);
        return response()->json($sections, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $language = Section::find($id);

        if (!$language) {
            return response()->json(['message' => 'Секция не найдена'], Response::HTTP_NOT_FOUND);
        }

        // Удаляем или обновляем связанные записи в таблице exercises
        // где язык используется как id_lang_task
        Exercise::where('id_section', $id)->delete(); // или обновляем, если нужно

        $language->delete();

        return response()->json(['message' => 'Секция успешно удалена'], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:sections'
        ]);

        $language = Section::create($validatedData);

        return response()->json($language, Response::HTTP_CREATED);
    }
}
