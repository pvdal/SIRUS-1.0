<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        // Paginação automática do Laravel
        $cursos = Course::paginate(10);

        return view('courses', compact('cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses',
            'shift' => 'required|in:Manhã,Tarde,Noite',
            'coordinator_cpf' => 'nullable|string|max:14',
        ]);

        $course = Course::create($request->all());

        return response()->json([
            'success' => true,
            'course' => $course,
            'message' => 'Curso salvo com sucesso!'
        ]);
    }
}
