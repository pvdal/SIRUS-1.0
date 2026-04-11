<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SimbajuCourseSheet implements FromArray, WithTitle, WithEvents
{
    // Paleta de cores
    const COLOR_YELLOW_TITLE = 'FFFF00';
    const COLOR_GREEN_SEMESTER = '92D050';
    const COLOR_BLUE_GROUP = '00B0F0';
    const COLOR_ORANGE_DATE = 'FFC000';
    const COLOR_WHITE = 'FFFFFF';
    const COLOR_DARK_TEXT = '000000';

    public array $sectionMeta = [];

    public function __construct(
        protected string $courseName,
        protected string $eventTitle,
        protected Collection $papersGroup, // Collection já agrupada por 'project' (1..6)
        protected int $year,
        protected int $semester
    ) {}



    // WithTitle
    public function title(): string
    {
        return mb_substr($this->courseName, 0, 31);
    }

    // FromArray
    public function array(): array
    {
        return [];
    }

    // WithEvents (AfterSheet)
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {


                $sheet = $event->sheet->getDelegate();
                $row   = 1;

                // 1. Descobrimos qual o maior número de grupos entre todos os projetos para saber até onde formatar
                $maxGroupsCount = $this->papersGroup->max(function ($projectPapers) {
                    return $projectPapers->count();
                });

                // 2. Definimos a largura da coluna A (Etiquetas)
                $sheet->getColumnDimension('A')->setWidth(24);

                // 3. Loop dinâmico: Começa em 2 (B) e vai até a última coluna necessária (1 + maxGroupsCount)
                for ($i = 2; $i <= (1 + $maxGroupsCount); $i++) {
                    $colLetter = $this->colLetter($i);
                    $sheet->getColumnDimension($colLetter)->setWidth(43);
                }


                // Linha 1: Título do evento─
                $sheet->mergeCells("A{$row}:H{$row}");
                $sheet->setCellValue("A{$row}", $this->eventTitle);
                $this->styleTitle($sheet, "A{$row}:H{$row}");
                $sheet->getRowDimension($row)->setRowHeight(42.75);
                $row++;

                // Linha 2: vazia (espaçamento)                $row++;

                // Blocos por Projeto (1 a 6)
                // Como papersGroup já foi agrupado por 'project' na classe principal,
                // a chave ($projectNum) será o número do projeto (1, 2, 3...)
                foreach ($this->papersGroup as $projectNum => $projectPapers) {
                    $row = $this->writeProjectBlock($sheet, $row, $projectNum, $projectPapers);
                    $row += 2; // Espaço entre os blocos de projetos
                }

                // Larguras das colunas
                $sheet->getColumnDimension('A')->setWidth(24);
                foreach (['B', 'C', 'D', 'E', 'F', 'G'] as $col) {
                    $sheet->getColumnDimension($col)->setWidth(43);
                }
                $sheet->getColumnDimension('H')->setWidth(43);
            },
        ];
    }

    // MÉTODOS AUXILIARES

    private function writeProjectBlock($sheet, int $row, int $projectNum, Collection $papers): int
    {
        // Ordena pela data do comitê de forma crescente.
        // Se houver trabalhos sem data (nulos), eles ficarão no início.
        // O ->values() no final reconstrói os índices numéricos (0, 1, 2...) na nova ordem correta.
        $groups = $papers->sortBy(function ($paper) {
            return $paper->committee?->start;
        })->values();

        $groupCount = $groups->count();
        $lastCol    = $this->colLetter(1 + $groupCount);

        // Linha: "Projeto X - CURSO" (merge A:lastCol)
        $projectLabel = "Projeto {$projectNum} - {$this->courseName}";
        $endCol       = $this->colLetter(1 + $groupCount);

        $sheet->mergeCells("A{$row}:{$endCol}{$row}");
        $sheet->setCellValue("A{$row}", $projectLabel);
        $this->styleSemesterHeader($sheet, "A{$row}:{$endCol}{$row}");
        $sheet->getRowDimension($row)->setRowHeight(37.5);
        $row++;

        // Linha: "GRUPO 1 | GRUPO 2 | ..."─
        $col = 2; // Coluna B
        foreach ($groups as $index => $paper) {
            $cell = $this->colLetter($col) . $row;
            // O index começa em 0, então somamos 1 para a exibição visual
            $numGrupo = $index + 1;

            $sheet->setCellValue($cell, "GRUPO {$numGrupo}");
            $this->styleGroupHeader($sheet, $cell);
            $col++;
        }
        $sheet->getRowDimension($row)->setRowHeight(23);
        $row++;

        // Linhas: membros dos grupos
        $memberStartRow = $row;
        $maxMembers     = 0;

        $membersByCol = [];
        $col          = 2;
        foreach ($groups as $paper) {
            $members = $paper?->group?->students?->pluck('user.name')->toArray() ?? [];
            $membersByCol[$col] = $members;
            $maxMembers = max($maxMembers, count($members));
            $col++;


        }

        if ($maxMembers > 1) {
            $sheet->mergeCells("A{$memberStartRow}:A" . ($memberStartRow + $maxMembers - 1));
        }
        $sheet->setCellValue("A{$memberStartRow}", 'GRUPO:');
        $sheet->getStyle("A{$memberStartRow}")->getFont()->setBold(true);
        $sheet->getStyle("A{$memberStartRow}")->getFont()->setSize(12);
        $sheet->getStyle("A{$memberStartRow}")->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A{$memberStartRow}")->getAlignment()->setVertical('center');

        // Borda na célula GRUPO
        if ($maxMembers > 1) {
            $this->applyBorders($sheet, "A{$memberStartRow}:A" . ($memberStartRow + $maxMembers - 1));
        } else {
            $this->applyBorders($sheet, "A{$memberStartRow}");
        }

        for ($i = 0; $i < $maxMembers; $i++) {
            foreach ($membersByCol as $colIdx => $members) {
                $name = $members[$i] ?? '';
                $cell = $this->colLetter($colIdx) . ($memberStartRow + $i);
                $sheet->setCellValue($cell, $name);
                $sheet->getStyle($cell)->getAlignment()
                    ->setHorizontal('center')
                    ->setWrapText(true);

                $this->applyBorders($sheet, $cell);
            }
            $sheet->getRowDimension($memberStartRow + $i)->setRowHeight(20);
        }
        $row += $maxMembers;

        // Linha: Tema
        $sheet->setCellValue("A{$row}", 'Tema:');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true);
        $this->applyBorders($sheet, "A{$row}");
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal('right');

        $col = 2;
        foreach ($groups as $paper) {
            $cell  = $this->colLetter($col) . $row;

            $sheet->setCellValue($cell, $paper->group->theme ?? '');
            $sheet->getStyle($cell)->getAlignment()
                ->setHorizontal('center')
                ->setWrapText(true);
            $this->applyBorders($sheet, $cell);
            $col++;
        }
//        $sheet->getRowDimension($row)->setRowHeight(30.5);
        $row++;

        // Linha: DATA
        $sheet->setCellValue("A{$row}", 'DATA');

        // Aplica o estilo, alinhamento e a cor de fundo
        $sheet->getStyle("A{$row}")->applyFromArray([
            'font'      => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'fill'      => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFDAF2D0'] // Sua cor aqui!
            ],
        ]);

        $this->applyBorders($sheet, "A{$row}");




        $col = 2;
        foreach ($groups as $paper) {
            $dateLabel = $paper?->committee?->start
                ? $paper->committee->start->format('d/m/Y - H\hi')
                : '';
            $cell = $this->colLetter($col) . $row;
            $sheet->setCellValue($cell, $dateLabel);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getFont()->setSize(12);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal('center');

            $bgColor = $this->resolveDateColor($paper?->committee?->start);
            if ($bgColor) {
                $sheet->getStyle($cell)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF' . $bgColor);
            }

            //$cell = $this->colLetter($col) . $row;
            //$sheet->setCellValue($cell, $dateLabel);

            // Chama o helper para garantir que essa célula "mexida" tenha borda
            $this->applyBorders($sheet, $cell);


            $col++;
        }
        $sheet->getRowDimension($row)->setRowHeight(21);
        $row++;

        // Linhas: PROFESSORES
        $profStartRow = $row;
        $maxEvaluators = 0;
        $evaluatorsByCol = [];
        $col = 2;

        foreach ($groups as $paper) {
            // Alterado de pluck('name') para pluck('user.name')
            // para manter a consistência com a tabela de usuários
            $evals = $paper?->committee?->members?->pluck('user.name')->toArray() ?? [];
            $evaluatorsByCol[$col] = $evals;
            $maxEvaluators = max($maxEvaluators, count($evals));
            $col++;
        }

        // Descobre se precisa fazer merge e qual é o intervalo (range)
        if ($maxEvaluators > 1) {
            $rangeLabel = "A{$profStartRow}:A" . ($profStartRow + $maxEvaluators - 1);
            $sheet->mergeCells($rangeLabel);
        } else {
            $rangeLabel = "A{$profStartRow}";
        }

        $sheet->setCellValue("A{$profStartRow}", 'PROFESSORES');

        // Pinta todo o bloco (mesclado ou não) com a sua cor
        $sheet->getStyle($rangeLabel)->applyFromArray([
            'font'      => ['bold' => true],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'fill'      => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFDAF2D0'] // Sua cor aqui!
            ],
        ]);

        // Aplica a borda no bloco inteiro
        $this->applyBorders($sheet, $rangeLabel);

        for ($i = 0; $i < max($maxEvaluators, 1); $i++) {
            foreach ($evaluatorsByCol as $colIdx => $evals) {
                $name = $evals[$i] ?? '';
                $cell = $this->colLetter($colIdx) . ($profStartRow + $i);
                $sheet->setCellValue($cell, $name);
                $sheet->getStyle($cell)->getAlignment()->setHorizontal('center');
                $this->applyBorders($sheet, $cell);

            }
            $sheet->getRowDimension($profStartRow + $i)->setRowHeight(14.4);
        }
        $row += max($maxEvaluators, 1);

        $row++;

        return $row;
    }

    //Helpers de estilo
    private function styleTitle($sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font'      => ['bold' => true, 'size' => 22],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF' . self::COLOR_YELLOW_TITLE]],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders'   => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
    }

    private function styleSemesterHeader($sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font'      => ['bold' => true, 'size' => 20],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF' . self::COLOR_GREEN_SEMESTER]],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Preto Puro
                ],
            ],
        ]);
    }

    private function styleGroupHeader($sheet, string $cell): void
    {
        $sheet->getStyle($cell)->applyFromArray([
            'font'      => ['bold' => true, 'size' => 12],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF' . self::COLOR_BLUE_GROUP]],
            'alignment' => ['horizontal' => 'center'],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Preto Puro
                ],
            ],
        ]);
        $this->applyBorders($sheet, $cell);

    }

    private function resolveDateColor(?\Carbon\Carbon $date): ?string
    {
        // Se não tiver data, retorna nulo (sem cor de fundo)
        if (! $date) return null;

        // Pega apenas o último dígito do dia (ex: 24 vira 4, 10 vira 0)
        $lastDigit = $date->day % 10;

        // Retorna o código hexadecimal correspondente sem o "#"
        return match ($lastDigit) {
            0 => 'FFC000',
            1 => 'FFFF00',
            2 => 'F2CEEF',
            3 => 'D0D0D0',
            4 => 'C1F0C8',
            5 => 'C0E6F5',
            6 => 'FFC000',
            7 => 'D86DCD',
            8 => 'DAF2D0',
            9 => 'FFFF00',
            default => null, // Apenas por segurança
        };
    }

    private function colLetter(int $index): string
    {
        $letter = '';
        while ($index > 0) {
            $mod    = ($index - 1) % 26;
            $letter = chr(65 + $mod) . $letter;
            $index  = (int)(($index - $mod) / 26);
        }
        return $letter;
    }

    private function applyBorders($sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Preto
                ],
            ],
        ]);
    }
}
