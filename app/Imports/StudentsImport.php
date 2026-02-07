<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Str;
use App\Notifications\QueuedSendPasswordNotification;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class StudentsImport implements ToCollection, WithHeadingRow
{
    public $rowsProcessed = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $data = $row->toArray();

            $validator = Validator::make($data, [
                'ra'    => ['required', 'digits:13','unique:students,ra'],
                'nome'  => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'curso_id' => ['required','exists:courses,id'],
                'grupo_id' => ['nullable','exists:groups,id'],
            ], [
                'email.unique' => 'E-mail já cadastrado',
                'ra.unique'    => 'RA já cadastrado',
                'curso_id.exists' => 'Curso não encontrado',
                'grupo_id.exists' => 'Grupo não encontrado',
            ]);

            if ($validator->fails()) {
                $data['Resultado da Importação'] = $validator->errors()->first();
            } else {
                try {
                    $password = Str::random(10);
                    $user = User::create([
                        'name' => $data['nome'],
                        'email' => $data['email'],
                        'password' => bcrypt($password),
                    ]);

                    Student::create([
                        'user_id' => $user->id,
                        'ra' => $data['ra'],
                        'course_id' => $data['curso_id'],
                        'group_id' => $data['grupo_id'],
                    ]);

                    $data['Resultado da Importação'] = 'Importado com sucesso';

                    $user->notify(new QueuedSendPasswordNotification($password));
                } catch (\Exception $e) {
                    $data['Resultado da Importação'] = 'Erro técnico: ' . $e->getMessage();
                }
            }

            $this->rowsProcessed[] = $data;
        }
    }
}
