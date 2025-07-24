<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    protected $primaryKey = 'coordinator_cpf'; // Chave primária personalizada (string)
    public $incrementing = false; // Impede autoincremento
    protected $keyType = 'string'; // Define como string

    protected $fillable = [
        'coordinator_cpf',
        'user_id',
    ];

    // Relacionamento com o User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->hasOne(Course::class,'coordinator_cpf','coordinator_cpf');
    }
}
