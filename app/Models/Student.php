<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'ra'; // Chave primária personalizada (string)
    public $incrementing = false; // Impede autoincremento
    protected $keyType = 'string'; // Define como string

    // Campos que serão aceitos por esse model usando os métodos eloquent
    protected $fillable = [
        'ra',
        'user_id',
        'semester',
        'course_id',
        'group_id'
    ];
    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relacionamento com Course
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    // Relacionamento com Course
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id');
    }
}
