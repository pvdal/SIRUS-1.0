<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    // Campos que serão aceitos por esse model usando os métodos eloquent
    protected $fillable = [
        'theme',
        'state',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Escopo para grupos ativos
    public function scopeActive($query)
    {
        return $query->where('state', 1);
    }

    #region Relacionamentos
    // Relacionamento com Student
    public function students(): HasMany
    {
        return $this->hasMany(Student::class,'group_id');
    }

    // Relacionamento com ‘Papers’
    public function papers(): HasMany
    {
        return $this->hasMany(Paper::class,'group_id');
    }
    #endregion
}
