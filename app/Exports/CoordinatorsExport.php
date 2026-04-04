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
        // Mantemos o Eager Loading para performance
        $query = Coordinator::query()->with(['user.education']);

        return $query
            ->when($this->filters['search'], function ($q, $search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where(function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhereHas('education', function ($edu) use ($search) {
                                $edu->where('level', 'like', "%{$search}%")
                                    ->orWhere('course', 'like', "%{$search}%")
                                    ->orWhere('institution', 'like', "%{$search}%");
                            });
                    });
                });
            })
            ->when(isset($this->filters['status']) && $this->filters['status'] !== '', function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('state', $this->filters['status']);
                });
            })
            ->when($this->filters['period'] && $this->filters['period'] !== '[object Object]', function ($q) {
                $this->applyPeriodFilter($q, $this->filters['period']);
            });
    }

    public function headings(): array {
        // Adicionadas as 4 novas colunas no lugar de "Formação"
        return [
            'Nome',
            'Email',
            'Graduação',
            'Especialização',
            'Mestrado',
            'Doutorado',
            'Data de Cadastro'
        ];
    }

    public function map($row): array {

        $getEducationText = function ($levelToFind) use ($row) {
            if (!$row->user || !$row->user->education) {
                return '-';
            }

            // A busca continua flexível, mas agora vai procurar pelas palavras em inglês
            $edu = $row->user->education->filter(function($item) use ($levelToFind) {
                return stripos($item->level, $levelToFind) !== false;
            })->first();

            if ($edu) {
                return trim($edu->course) ?: 'Não informado';
            }

            return '-';
        };

        return [
            $row->user->name,
            $row->user->email,
            // Agora passando os valores exatos que estão no seu banco de dados
            $getEducationText('graduation'),
            $getEducationText('specialization'),
            // IMPORTANTE: Confirme se os nomes abaixo estão salvos como 'master' e 'doctorate' no seu BD
            $getEducationText('master'),
            $getEducationText('doctorate'),
            $row->created_at?->format('d/m/Y') ?? $row->user->created_at?->format('d/m/Y'),
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
            'today' => $query->whereDate('created_at', $now->today()),
            'week'  => $query->whereDate('created_at', $now->week()),
            'month' => $query->where('created_at', '>=', $now->subDays(30)),
            default => null,
        };
    }
}
