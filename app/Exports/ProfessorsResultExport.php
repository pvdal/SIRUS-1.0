<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfessorsResultExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    protected $results;

    public function __construct(array $results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return collect($this->results);
    }

    public function map($row): array
    {
        return [
            $row['nome'] ?? $row['Nome'] ?? '',
            $row['email'] ?? $row['Email'] ?? '',
            $row['graduacao'] ?? $row['Graduação'] ?? '-',
            $row['especializacao'] ?? $row['Especialização'] ?? '-',
            $row['mestrado'] ?? $row['Mestrado'] ?? '-',
            $row['doutorado'] ?? $row['Doutorado'] ?? '-',
            $row['resultado'] ?? $row['resultado_da_importacao'] ?? '',
        ];
    }

    public function headings(): array
    {
        return ['Nome', 'Email', 'Graduação','Especialização','Mestrado','Doutorado', 'Resultado da Importação'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(40);
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E293B']]]
        ];
    }
}
