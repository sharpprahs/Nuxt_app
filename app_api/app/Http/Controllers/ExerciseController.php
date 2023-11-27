<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function getThemes(Request $request)
    {
        $idLangTask = $request->input('id_lang_task');
        $idLangAnswer = $request->input('id_lang_answer');
        $idSection = $request->input('id_section');
        $page = $request->input('page', 1); // Получаем номер страницы, по умолчанию 1

        $query = Exercise::query();

        if ($idLangTask) {
            $query->where('id_lang_task', $idLangTask);
        }

        if ($idLangAnswer) {
            $query->where('id_lang_answer', $idLangAnswer);
        }

        if ($idSection) {
            $query->where('id_section', $idSection);
        }

        $themes = $query->paginate(8, ['*'], 'page', $page); // Пагинация по 8 записей на страницу

        return response()->json([
            'themes' => $themes->items(),
            'total' => $themes->total(),
            'currentPage' => $themes->currentPage(),
            'lastPage' => $themes->lastPage(),
        ]);
    }
}
