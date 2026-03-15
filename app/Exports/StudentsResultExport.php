<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsResultExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
            $row['ra'],
            $row['nome'],
            $row['email'],
            $row['curso_id'],
            $row['grupo_id'],
            $row['resultado'],
        ];
    }

    public function headings(): array
    {
        return ['RA','Nome', 'E-mail', 'Curso_id','Grupo_id', 'Resultado da Importação'];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(30);
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E293B']],
                'alignment' => ['horizontal' => 'center']
            ]
        ];
    }
}
