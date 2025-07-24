<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    // Campos que serão aceitos por esse model usando os métodos eloquent
    protected $fillable = [
        'name',
        'description',
    ];
    // Relacionamento com Student
    public function students()
    {
        return $this->hasMany(Student::class,'group_id');
    }
}
