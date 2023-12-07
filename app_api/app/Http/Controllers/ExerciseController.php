<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ExerciseController extends Controller
{
    public function getThemes(Request $request)
    {
        $idLangTask = $request->input('id_lang_task');
        $idLangAnswer = $request->input('id_lang_answer');
        $idSection = $request->input('id_section');
        $page = $request->input('page', 1);

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

        // Получение тем без пагинации и фильтрация уникальных по имени
        $themes = $query->get()->unique('name');

        // Применение пагинации к отфильтрованной коллекции
        $perPage = 8;
        $currentItems = $themes->slice(($page - 1) * $perPage, $perPage)->values();
        $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems, $themes->count(), $perPage, $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return response()->json([
            'themes' => $paginatedItems->items(),
            'total' => $paginatedItems->total(),
            'currentPage' => $paginatedItems->currentPage(),
            'lastPage' => $paginatedItems->lastPage(),
        ]);
    }
    public function create(Request $request)
    {
        // Валидация входящих данных
        $validatedData = $request->validate([
            'id_lang_task' => 'required|integer',
            'id_lang_answer' => 'required|integer',
            'id_section' => 'required|integer',
            'name' => 'required|string|max:255|unique:exercises',
        ]);

        // Создание нового упражнения с дополнительными статическими данными
        $exercise = Exercise::create([
            'id_lang_task' => $validatedData['id_lang_task'],
            'id_lang_answer' => $validatedData['id_lang_answer'],
            'id_section' => $validatedData['id_section'],
            'name' => $validatedData['name'],
            'number_task' => 1, // Статическое значение
            'type' => 'img', // Статическое значение
            'content_name' => 'first.png', // Статическое значение
            'description' => 'Дефолтное упражнение', // Статическое значение
            'true_answer' => 'Укажите правильный ответ', // Статическое значение
            'true_keywords' => 'Правильный ответ' // Статическое значение
        ]);

        // Ответ с созданной записью и статусом 201 (Created)
        return response()->json($exercise, Response::HTTP_CREATED);
    }
    public function getExercises(Request $request)
    {
        // Получение параметров запроса
        $idLangTask = $request->input('id_lang_task');
        $idLangAnswer = $request->input('id_lang_answer');
        $idSection = $request->input('id_section');
        $name = $request->input('name');
        $page = $request->input('page', 1); // Значение по умолчанию - 1

        // Создание запроса с фильтрацией
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
        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%"); // Поиск по части имени
        }

        // Получение общего количества записей
        $countSize = $query->count();

        // Пагинация результатов
        $exercises = $query->paginate(10, ['*'], 'page', $page);

        // Возвращение данных в формате JSON
        return response()->json([
            'exercises' => $exercises,
            'count_size' => $countSize
        ]);
    }
    public function addExercise(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'id_lang_task' => 'required|integer',
            'id_lang_answer' => 'required|integer',
            'id_section' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        // Получение номера последнего задания
        $lastExercise = Exercise::where('id_lang_task', $validated['id_lang_task'])
            ->where('id_lang_answer', $validated['id_lang_answer'])
            ->where('id_section', $validated['id_section'])
            ->where('name', $validated['name'])
            ->orderBy('number_task', 'desc')
            ->first();

        $numberTaskAdd = $lastExercise ? $lastExercise->number_task + 1 : 1;

        // Создание нового задания
        $newExercise = Exercise::create([
            'id_lang_task' => $validated['id_lang_task'],
            'id_lang_answer' => $validated['id_lang_answer'],
            'id_section' => $validated['id_section'],
            'name' => $validated['name'],
            'number_task' => $numberTaskAdd,
            'type' => 'img',
            'content_name' => 'first.png',
            'description' => 'Дефолтное упражнение',
            'true_answer' => 'Укажите правильный ответ',
            'true_keywords' => 'Правильный ответ',
        ]);

        return response()->json($newExercise, 201);
    }
    public function deleteExercises(Request $request)
    {
        $exercises = Exercise::where('id_lang_task', $request->id_lang_task)
            ->where('id_lang_answer', $request->id_lang_answer)
            ->where('id_section', $request->id_section)
            ->where('name', $request->name)
            ->get();

        if ($exercises->isEmpty()) {
            return response()->json(['message' => 'Задания не найдены'], 404);
        }

        foreach ($exercises as $exercise) {
            $exercise->delete();
        }

        return response()->json(['message' => 'Задания удалены'], 200);
    }
    public function checkIfThemeExists(Request $request)
    {
        // Получение параметров запроса
        $idLangTask = $request->input('id_lang_task');
        $idLangAnswer = $request->input('id_lang_answer');
        $idSection = $request->input('id_section');
        $name = $request->input('name');

        // Поиск темы
        $themeExists = Exercise::where('id_lang_task', $idLangTask)
            ->where('id_lang_answer', $idLangAnswer)
            ->where('id_section', $idSection)
            ->where('name', $name)
            ->exists();

        // Возвращаем true или false в зависимости от того, найдена тема или нет
        return response()->json(['exists' => $themeExists]);
    }
    public function deleteTaskExercise(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'id_lang_task' => 'required|integer',
            'id_lang_answer' => 'required|integer',
            'id_section' => 'required|integer',
            'name' => 'required|string|max:255',
            'number_task' => 'required|integer'
        ]);

        // Поиск и удаление задания
        $exercise = Exercise::where([
            ['id_lang_task', $validated['id_lang_task']],
            ['id_lang_answer', $validated['id_lang_answer']],
            ['id_section', $validated['id_section']],
            ['name', $validated['name']],
            ['number_task', $validated['number_task']]
        ])->first();

        if (!$exercise) {
            return response()->json(['message' => 'Задание не найдено'], 404);
        }

        $exercise->delete();

        return response()->json(['message' => 'Задание успешно удалено'], 200);
    }
}
