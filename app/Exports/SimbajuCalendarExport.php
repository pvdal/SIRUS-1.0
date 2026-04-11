<?php

namespace App\Exports;

use App\Models\Paper;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SimbajuCalendarExport implements WithMultipleSheets
{
    // Usando Constructor Property Promotion deixa o código muito mais limpo
    public function __construct(
        protected string $eventTitle,
        protected int $year,
        protected int $semester
    ) {}

    public function sheets(): array
    {
        // Busca todos os cursos que têm papers no semestre/ano informados
        $courses = Course::whereHas('papers', function ($q) {
            $q->where('year', $this->year)
                ->where('semester', $this->semester);
        })->get();

        $sheets = [];

        foreach ($courses as $course) {
            // 'group.students.user' para garantir que os nomes
            // já venham na consulta principal, evitando N+1 queries na montagem da planilha.
            $papers = Paper::with(['group.students.user', 'committee.members.user'])
                ->where('course_id', $course->id)
                ->where('year', $this->year)
                ->where('semester', $this->semester)
                ->get()
                ->groupBy('project'); // project = 1..6 (coluna de grupo de apresentação)

            $sheets[] = new SimbajuCourseSheet(
                courseName:  $course->name,
                eventTitle:  $this->eventTitle,
                papersGroup: $papers,
                year:        $this->year,
                semester:    $this->semester,
            );
        }

        // ==========================================
        // A CORREÇÃO ENTRA AQUI
        // ==========================================
        // Se após o loop o array $sheets continuar vazio,
        // geramos uma aba de fallback para o Excel não quebrar.
        if (empty($sheets)) {
            $sheets[] = new SimbajuCourseSheet(
                courseName:  'Sem Registros', // Nome que vai aparecer na aba do Excel
                eventTitle:  $this->eventTitle,
                papersGroup: collect(),       // Passa uma coleção do Laravel vazia
                year:        $this->year,
                semester:    $this->semester,
            );
        }

        return $sheets;
    }
}
