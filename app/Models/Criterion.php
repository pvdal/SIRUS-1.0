<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'description',
        'state',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     * Isso garante que o 'state' sempre seja true/false no PHP.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'state' => 1,
    ];

    // No futuro, se um Critério pertencer a alguma outra coisa
    // (ex: um Curso), você definiria o relacionamento aqui.
    // Exemplo:
    // public function course()
    // {
    //     return $this->belongsTo(Course::class);
    // }
}
