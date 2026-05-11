<?php

namespace App\Http\Controllers\Api\Bi;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AcademicBiController extends Controller
{
    /**
     * Demografia: Quantidade de alunos por Curso e Turno.
     */
    public function getDemographics(): JsonResponse
    {
        $data = DB::table('students')
            ->join('courses', 'students.course_id', '=', 'courses.id')
            ->select(
                'courses.name as course',
                'courses.shift',
                DB::raw('COUNT(students.id) as total_students'),
                DB::raw('SUM(CASE WHEN students.group_id IS NOT NULL THEN 1 ELSE 0 END) as students_in_groups'),
                DB::raw('SUM(CASE WHEN students.group_id IS NULL THEN 1 ELSE 0 END) as students_without_groups')
            )
            ->where('courses.state', 1)
            ->groupBy('courses.id', 'courses.name', 'courses.shift')
            ->get();

        return response()->json([
            'success' => true,
            'dataset' => $data
        ]);
    }

    /**
     * Evolução e Volume de Trabalhos (Papers).
     */
    public function getPapersEvolution(): JsonResponse
    {
        $data = DB::table('papers')
            ->join('courses', 'papers.course_id', '=', 'courses.id')
            ->leftJoin('committees', 'papers.id', '=', 'committees.paper_id')
            ->select(
                'papers.year',
                'papers.semester',
                'courses.name as course',
                'papers.version',
                DB::raw('COUNT(DISTINCT papers.id) as total_papers'),
                DB::raw('COUNT(DISTINCT committees.id) as papers_with_committee'),
                DB::raw('SUM(CASE WHEN committees.id IS NULL THEN 1 ELSE 0 END) as papers_without_committee')
            )
            ->where('papers.state', 1)
            ->groupBy('papers.year', 'papers.semester', 'courses.id', 'courses.name', 'papers.version')
            ->orderBy('papers.year')
            ->orderBy('papers.semester')
            ->get();

        return response()->json(['success' => true, 'dataset' => $data]);
    }

    /**
     * Carga de trabalho dos coordenadores de banca.
     */
    public function getCommitteeWorkload(): JsonResponse
    {
        $data = DB::table('committees')
            ->join('coordinators', 'committees.coordinator_id', '=', 'coordinators.id')
            ->join('users', 'coordinators.user_id', '=', 'users.id')
            ->select(
                'users.name as coordinator_name',
                DB::raw('COUNT(committees.id) as total_committees_managed'),
                DB::raw('COUNT(DISTINCT committees.paper_id) as total_papers_allocated')
            )
            ->where('committees.state', 1)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_committees_managed')
            ->get();

        return response()->json(['success' => true, 'dataset' => $data]);
    }
}
