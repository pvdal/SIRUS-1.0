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
    // Relacionamento com Student
    public function students(): HasMany
    {
        return $this->hasMany(Student::class,'group_id');
    }

    public function papers(): HasMany
    {
        return $this->hasMany(Paper::class,'group_id');
    }

    public function professor_committee(): HasMany
    {
        return $this->hasMany(ProfessorCommittee::class,'group_id');
    }
}
