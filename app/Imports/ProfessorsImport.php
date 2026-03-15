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

    public function collection(Collection $rows):void
    {
        foreach ($rows as $row) {
            $data = $row->toArray();

            $validator = Validator::make($data, [
                'nome'  => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'formacao' => ['nullable','string', 'max:255'],
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
                        'education' => $data['formacao']
                    ]);
                    $data['resultado_da_importacao'] = 'Importado com sucesso';
                    $user->sendTemporaryPasswordNotification($password);
                } catch (\Exception $e) {
                    $data['resultado_da_importacao'] = 'Erro técnico: ' . $e->getMessage();
                }
            }
            $this->rowsProcessed[] = [
                'nome'      => $row['nome'],
                'email'     => $row['email'],
                'formacao'  => $row['formacao'] ?? '',
                'resultado' => $data['resultado_da_importacao']
            ];
        }
    }
}
