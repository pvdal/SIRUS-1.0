<?php

namespace App\Exports;

use App\Models\Criterion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CriteriaExport implements FromQuery, WithMapping, WithHeadings, WithStyles
{
    protected $filters;

    public function __construct($filters) {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Criterion::query();

        return $query
            ->when($this->filters['search'], function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('unsatisfactory', 'like', "%{$search}%")
                    ->orwhere('satisfactory', 'like', "%{$search}%")
                    ->orwhere('good', 'like', "%{$search}%")
                    ->orwhere('excellent', 'like', "%{$search}%");
            })
            ->when(isset($this->filters['status']) && $this->filters['status'] !== '', function ($q) {
                $q->where('state', $this->filters['status']);
            })
            ->when(!empty($this->filters['period']) && $this->filters['period'] !== '[object Object]', function ($q) {
                $this->applyPeriodFilter($q, $this->filters['period']);
            });
    }

    public function headings(): array {
        return ['Nome', 'Insatisfatório','Satisfatório','Bom','Excelente','Data de cadastro'];
    }

    public function map($row): array {
        return [
            $row->name,
            $row->unsatisfactory,
            $row->satisfactory,
            $row->good,
            $row->excellent,
            $row->created_at->format('d/m/Y'),
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
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(15);
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E293B']],
                'alignment' => ['horizontal' => 'center'],
            ]
        ];
    }
}
