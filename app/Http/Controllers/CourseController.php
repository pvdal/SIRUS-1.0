<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function index()
    {
        // Paginação automática do Laravel
        $coordinators = Coordinator::with('user')->get();
        $courses = Course::with('coordinator')->paginate(10);

        return view('management.courses', compact('courses', 'coordinators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses',
            'shift' => 'required|in:morning,afternoon,night',
            'coordinator_id' => 'nullable|integer|unique:courses|exists:coordinators,id',
        ]);

        $course = Course::create($request->all());

        return response()->json([
            'success' => true,
            'course' => $course,
            'message' => 'Curso salvo com sucesso!'
        ]);
    }
}
