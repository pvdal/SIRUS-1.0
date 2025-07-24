<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // Campos que serão aceitos por esse model usando os métodos eloquent
    protected $fillable = [
        'name',
        'shift',
        'coordinator_cpf',
        'state',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope para cursos ativos
    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }
    // Relacionamento com Coordinator
    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class,'coordinator_cpf','coordinator_cpf');
    }
}
