<?php

namespace App\Imports;

use App\Utils\PasswordGenerator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Professor;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfessorsImport implements ToCollection, WithHeadingRow
{
    public $rowsProcessed = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $data = $row->toArray();
            $validator = Validator::make($data, [
                'nome'           => ['required', 'string'],
                'email'          => ['required', 'email', 'unique:users,email'],
                'graduacao'      => ['nullable', 'string'],
                'especializacao' => ['nullable', 'string'],
                'mestrado'       => ['nullable', 'string'],
                'doutorado'      => ['nullable', 'string'],
            ], [
                'email.unique' => 'E-mail já cadastrado',
            ]);

            if ($validator->fails()) {
                $data['resultado_da_importacao'] = $validator->errors()->first();
            } else {
                try {
                    $password = PasswordGenerator::random();
                    $user = User::create([
                        'name' => $data['nome'],
                        'email' => $data['email'],
                        'password' => bcrypt($password)
                    ]);
                    Professor::create([
                        'user_id' => $user->id,
                    ]);
                    //Mapear os níveis do BD com as colunas
                    $educations = [
                        'graduation'     => $data['graduacao'] ?? null,
                        'specialization' => $data['especializacao'] ?? null,
                        'masters'         => $data['mestrado'] ?? null,
                        'doctorate'      => $data['doutorado'] ?? null,
                    ];
                    //Salvar na tabela faculty_education apenas os níveis que foram preenchidos
                    foreach ($educations as $level => $course) {
                        // Ignoramos vazios e também o traço '-' ou 'Não informado' caso
                        // o usuário tenha exportado a planilha, alterado algo e reimportado
                        if (!empty($course) && $course !== '-' && $course !== 'Não informado') {
                            $user->education()->create([
                                'level'  => $level,
                                'course' => trim($course),
                            ]);
                        }
                    }
                    $data['resultado_da_importacao'] = 'Importado com sucesso';
                    $user->sendTemporaryPasswordNotification($password);
                } catch (\Exception $e) {
                    $data['resultado_da_importacao'] = 'Erro técnico: ' . $e->getMessage();
                }
            }
            $this->rowsProcessed[] = [
                'nome'           => $row['nome'] ?? '',
                'email'          => $row['email'] ?? '',
                'graduacao'      => $row['graduacao'] ?? '',
                'especializacao' => $row['especializacao'] ?? '',
                'mestrado'       => $row['mestrado'] ?? '',
                'doutorado'      => $row['doutorado'] ?? '',
                'resultado'      => $data['resultado_da_importacao']
            ];
        }
    }
}
