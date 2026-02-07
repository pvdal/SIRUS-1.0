<?php

namespace App\Exports;

use App\Models\Coordinator;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CoordinatorsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters) {
        $this->filters = $filters;
    }

    public function query() {
        $query = Coordinator::query()->with('user');

        return $query
            ->when($this->filters['search'], function ($q, $search){
                $q->where(function ($sub) use ($search) {
                    $sub->whereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })->orWhere('education', 'like', "%{$search}%");
                });
            })
            ->when(isset($this->filters['status']) && $this->filters['status'] !== '', function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('state', $this->filters['status']);
                });
            })
            ->when($this->filters['period'] && $this->filters['period'] !== '[object Object]', function ($q) {
                $this-> applyPeriodFilter($q, $this->filters['period']);
            });
    }

    public function headings(): array {
        return ['Nome', 'Email','Formação', 'Data de Cadastro'];
    }

    public function map($row): array {
        return [
            $row->user->name,
            $row->user->email,
            $row->education,
            $row->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E293B']]]
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
}
