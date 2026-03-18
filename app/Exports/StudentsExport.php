<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class StudentsExport extends StringValueBinder implements FromQuery, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithCustomValueBinder
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }


    public function query()
    {
        $query = Student::query()->with(['user', 'course', 'group']);

        return $query
            ->when($this->filters['search'], function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->whereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })->orWhere('ra', 'like', "%{$search}%");
                });
            })->when($this->filters['course_id'], function ($q, $course_id) {
                $q->where('course_id', $course_id);
            })->when($this->filters['group_id'], function ($q, $group_id) {
                $q->where('group_id', $group_id);
            })->when(isset($this->filters['status']) && $this->filters['status'] !== '', function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('state', $this->filters['status']);
                });
            })->when($this->filters['period'] && $this->filters['period'] !== '[object Object]', function ($q) {
                $this->applyPeriodFilter($q, $this->filters['period']);
            });
    }

    public function headings(): array
    {
        return [
            'RA',
            'Nome',
            'E-mail',
            'Curso',
            'Grupo',
            'Data de Cadastro'
        ];
    }

    public function map($student): array
    {
        return [
            $student->ra,
            $student->user->name,
            $student->user->email,
            $student->course->name ?? 'N/A',
            $student->group->theme ?? 'N/A',
            $student->created_at?->format('d/m/Y') ?? $student->user->created_at?->format('d/m/Y'),
        ];
    }

    protected function applyPeriodFilter($query, $period): void
    {
        $now = now();

        match ($period) {
            'today'     => $query->whereDate('created_at', $now->today()),
            'week' => $query->whereDate('created_at', $now->week()),
            'month' => $query->where('created_at', '>=', $now->subDays(30)),
            default => null,
        };
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '1E293B']
                ],
                'alignment' => [
                    'horizontal' => 'center'
                ]
            ],
        ];
    }
}
