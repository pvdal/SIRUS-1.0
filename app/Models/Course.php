<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // Traduz o inglês do banco para português
    public function getShiftPtAttribute(): string
    {
        return match (strtolower($this->shift)) {
            'morning' => 'Manhã',
            'afternoon' => 'Tarde',
            'night' => 'Noite',
            default => ucfirst($this->shift),
        };
    }

    // Escopo para cursos ativos
    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }

    #region Relacionamentos
    // Relacionamento com Coordinator
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(Coordinator::class);
    }

    // Relacionamento com Paper
    public function papers(): HasMany
    {
        return $this->hasMany(Paper::class);
    }
    #endregion
}
