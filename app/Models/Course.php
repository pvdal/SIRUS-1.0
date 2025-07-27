<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // Campos que serão aceitos por esse model usando os métodos eloquent
    protected $fillable = [
        'name',
        'shift',
        'coordinator_id',
        'state',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // App\Models\Course.php

    public function getShiftPtAttribute()
    {
        return match (strtolower($this->shift)) {
            'morning' => 'Manhã',
            'afternoon' => 'Tarde',
            'night' => 'Noite',
            default => ucfirst($this->shift),
        };
    }


    // Scope para cursos ativos
    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }
    // Relacionamento com Coordinator
    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }
}
