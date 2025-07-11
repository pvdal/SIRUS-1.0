<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $primaryKey = 'professor_cpf';
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'professor_cpf',
        'user_id',

    ];
    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
