<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfessorsTemplateExport implements WithHeadings, WithStyles
{
    public function headings(): array {
        // Atualizado para as 4 novas colunas no lugar de 'Formação'
        return ['Nome', 'Email', 'Graduação', 'Especialização', 'Mestrado', 'Doutorado'];
    }

    public function styles(Worksheet $sheet): array
    {
        // Ajustando as larguras para contemplar de A até F
        $sheet->getColumnDimension('A')->setWidth(30); // Nome
        $sheet->getColumnDimension('B')->setWidth(30); // Email
        $sheet->getColumnDimension('C')->setWidth(25); // Graduação
        $sheet->getColumnDimension('D')->setWidth(25); // Especialização
        $sheet->getColumnDimension('E')->setWidth(25); // Mestrado
        $sheet->getColumnDimension('F')->setWidth(25); // Doutorado

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E293B']],
                'alignment' =>['horizontal'=>'center']
            ]
        ];
    }
}
