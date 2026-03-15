<?php

namespace App\Imports;

use App\Models\Criterion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CriteriaImport implements ToCollection, WithHeadingRow
{
    public array $rowsProcessed = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $data = $row->toArray();

            $validator = Validator::make($data, [
                'nome' => ['required','unique:criteria,name', 'string'],
                'insatisfatorio' => ['required', 'string'],
                'satisfatorio' => ['required', 'string'],
                'bom' => ['required', 'string'],
                'excelente' => ['required', 'string'],
            ], [
                'nome.unique'   => 'Nome de critério já cadastrado!',
                'nome.required' => 'O nome do critério é obrigatório.',
                'insatisfatorio.required' => 'A descrição de insatisfatório é obrigatório.',
                'satisfatorio.required' => 'A descrição de satisfatório é obrigatório.',
                'bom.required' => 'A descrição de bom é obrigatório.',
                'excelente.required' => 'A descrição de excelente é obrigatório.',
                ]);
            if ($validator->fails()) {
                $data['resultado_da_importacao'] = $validator->errors()->first();
            } else {
                try {
                    Criterion::create([
                        'name' => $data['nome'],
                        'unsatisfactory' => $data['insatisfatorio'],
                        'satisfactory' => $data['satisfatorio'],
                        'good' => $data['bom'],
                        'excellent' => $data['excelente'],
                    ]);

                    $data['resultado_da_importacao'] = 'Importado com sucesso';

                } catch (\Exception $e) {
                    $data['resultado_da_importacao'] = 'Erro técnico: ' . $e->getMessage();
                }
            }

            $this->rowsProcessed[] = $data;

            $this->rowsProcessed[] = [
                'nome'      => $row['nome'],
                'insatisfatorio'     => $row['insatisfatorio'],
                'satisfatorio'  => $row['satisfatorio'],
                'bom'  => $row['bom'],
                'excelente' => $row['excelente'],
                'resultado_da_importacao' => $data['resultado_da_importacao'],
            ];
        }
    }
}
