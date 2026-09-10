<?php

namespace App\Http\Controllers\Api\Bi;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EvaluationBiController extends Controller
{
    /**
     * Média de notas dos grupos por Critério e Curso.
     */
    public function getGroupEvaluationsFlat(): JsonResponse
    {
        $data = DB::table('group_evaluations')
            ->join('criteria', 'group_evaluations.criteria_id', '=', 'criteria.id')
            ->join('user_committees', 'group_evaluations.user_committee_id', '=', 'user_committees.id')
            ->join('committees', 'user_committees.committee_id', '=', 'committees.id')
            ->join('papers', 'committees.paper_id', '=', 'papers.id')
            ->join('groups', 'papers.group_id', '=', 'groups.id')
            ->join('courses', 'papers.course_id', '=', 'courses.id')
            ->select(
                'courses.name as course',
                'criteria.name as criteria_name',
                'papers.year',
                'papers.semester',
                'papers.project',
                'groups.id as group_id',
                'groups.theme as group_theme',

                DB::raw('ROUND(AVG(group_evaluations.grade), 2) as avg_grade'),
                DB::raw('COUNT(group_evaluations.id) as evaluation_count')
            )
            ->where('courses.state', 1)
            ->groupBy('courses.name', 'criteria.name', 'papers.year', 'papers.semester', 'papers.project', 'groups.id', 'groups.theme')
            ->get();

        return response()->json([
            'success' => true,
            'dataset' => $data
        ]);
    }

    /**
     * Média de notas individuais por Critério e Curso.
     */
    public function getIndividualPerformance(): JsonResponse
    {
        $data = DB::table('individual_evaluations')
            ->join('students', 'individual_evaluations.ra', '=', 'students.ra')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('courses', 'students.course_id', '=', 'courses.id')
            ->join('user_committees', 'individual_evaluations.user_committee_id', '=', 'user_committees.id')
            ->join('committees', 'user_committees.committee_id', '=', 'committees.id')
            ->join('papers', 'committees.paper_id', '=', 'papers.id')
            ->join('criteria', 'individual_evaluations.criteria_id', '=', 'criteria.id')
            ->select(
                'users.name as student_name',
                'courses.name as course',
                'papers.year',
                'papers.semester',
                'papers.project',
                'criteria.name as criteria_name',
                DB::raw('ROUND(AVG(individual_evaluations.grade), 2) as individual_avg')
            )
            ->where('users.state', 1)
            ->groupBy('users.name', 'courses.name', 'criteria.name', 'papers.year', 'papers.semester', 'papers.project')
            ->get();

        return response()->json([
            'success' => true,
            'dataset' => $data
        ]);
    }

    /**
     * Análise de Rigor: Média de notas dadas por cada avaliador.
     */
    public function getEvaluatorStrictness(): JsonResponse
    {
        $data = DB::table('group_evaluations')
            ->join('user_committees', 'group_evaluations.user_committee_id', '=', 'user_committees.id')
            ->join('users', 'user_committees.user_id', '=', 'users.id')
            ->select(
                'users.name as evaluator_name',
                DB::raw('COUNT(group_evaluations.id) as total_evaluations'),
                DB::raw('ROUND(AVG(group_evaluations.grade), 2) as average_grade_given'),
                DB::raw('MAX(group_evaluations.grade) as max_grade'),
                DB::raw('MIN(group_evaluations.grade) as min_grade')
            )
            ->where('users.state', 1)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('average_grade_given')
            ->get();

        return response()->json([
            'success' => true,
            'dataset' => $data
        ]);
    }

    /**
     * Matriz de Rubricas: Distribuição de notas por Eixo e Critério.
     */
    public function getRubricMatrix(): JsonResponse
    {
        $data = DB::table('group_evaluations')
            ->join('criteria', 'group_evaluations.criteria_id', '=', 'criteria.id')
            ->join('axis_criteria', 'criteria.id', '=', 'axis_criteria.criteria_id')
            ->join('axes', 'axis_criteria.axis_id', '=', 'axes.id')
            ->select(
                'axes.name as axis_name',
                'criteria.name as criteria_name',
                DB::raw('ROUND(AVG(group_evaluations.grade), 2) as avg_grade')
            )
            ->where('axes.state', 1)
            ->groupBy('axes.name', 'criteria.name')
            ->get();

        return response()->json([
            'success' => true,
            'dataset' => $data
        ]);
    }

    /**
     * Leaderboard: Top Trabalhos Consolidados.
     */
    public function getLeaderboard(): JsonResponse
    {
        $data = DB::table('group_evaluations')
            ->join('user_committees', 'group_evaluations.user_committee_id', '=', 'user_committees.id')
            ->join('committees', 'user_committees.committee_id', '=', 'committees.id')
            ->join('papers', 'committees.paper_id', '=', 'papers.id')
            ->join('courses', 'papers.course_id', '=', 'courses.id')
            ->select(
                'papers.title as paper_title',
                'courses.name as course',
                'papers.year',
                'papers.semester',
                DB::raw('ROUND(AVG(group_evaluations.grade), 2) as final_score')
            )
            ->where('papers.state', 1)
            ->groupBy('papers.id', 'papers.title', 'courses.name', 'papers.year', 'papers.semester')
            ->orderByDesc('final_score')
            ->limit(50) // Limita aos top 50 para não pesar no BI
            ->get();

        return response()->json([
            'success' => true,
            'dataset' => $data
        ]);
    }

    /**
    * Tabela Fatos para Power BI
    */
    public function getFlatFacts(): JsonResponse
    {
        // ── Avaliações de Grupo ──────────────────────────────────────────────
        $group = DB::table('group_evaluations as ge')
            ->join('user_committees as uc', 'ge.user_committee_id', '=', 'uc.id')
            ->join('committees as c',       'uc.committee_id',      '=', 'c.id')
            ->join('papers as p',           'c.paper_id',           '=', 'p.id')
            ->join('groups as g',           'p.group_id',           '=', 'g.id')  // ← novo
            ->join('courses as co',         'p.course_id',          '=', 'co.id')
            ->join('users as avaliador',    'uc.user_id',           '=', 'avaliador.id')
            ->join('criteria as cr',        'ge.criteria_id',       '=', 'cr.id')
            ->select(
                DB::raw("'Grupo' as tipo_avaliacao"),
                'ge.grade as nota',
                'ge.created_at as data_avaliacao',
                'cr.name as criterio',
                'avaliador.name as avaliador',
                'co.name as curso',
                'co.shift as turno',
                'p.year as ano',
                'p.semester as semestre',
                'p.title as titulo_trabalho',
                'p.project',
                'g.id as grupo_id',        // ← novo
                'g.theme as grupo_tema',   // ← novo
                DB::raw('NULL as aluno'),
                DB::raw('NULL as ra')
            );

        // ── Avaliações Individuais ───────────────────────────────────────────
        $individual = DB::table('individual_evaluations as ie')
            ->join('user_committees as uc', 'ie.user_committee_id', '=', 'uc.id')
            ->join('committees as c',       'uc.committee_id',      '=', 'c.id')
            ->join('papers as p',           'c.paper_id',           '=', 'p.id')
            ->join('groups as g',           'p.group_id',           '=', 'g.id')  // ← novo
            ->join('courses as co',         'p.course_id',          '=', 'co.id')
            ->join('users as avaliador',    'uc.user_id',           '=', 'avaliador.id')
            ->join('criteria as cr',        'ie.criteria_id',       '=', 'cr.id')
            ->join('students as s',         'ie.ra',                '=', 's.ra')
            ->join('users as aluno_user',   's.user_id',            '=', 'aluno_user.id')
            ->select(
                DB::raw("'Individual' as tipo_avaliacao"),
                'ie.grade as nota',
                'ie.created_at as data_avaliacao',
                'cr.name as criterio',
                'avaliador.name as avaliador',
                'co.name as curso',
                'co.shift as turno',
                'p.year as ano',
                'p.semester as semestre',
                'p.title as titulo_trabalho',
                'p.project',
                'g.id as grupo_id',        // ← novo
                'g.theme as grupo_tema',   // ← novo
                'aluno_user.name as aluno',
                'ie.ra as ra'
            );

        $data = $group->unionAll($individual)->get();

        return response()->json(['success' => true, 'dataset' => $data]);
    }
}
