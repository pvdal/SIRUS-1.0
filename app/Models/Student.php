<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'ra'; // Chave primária personalizada (string)
    public $incrementing = false; // Impede autoincremento
    protected $keyType = 'string'; // Define como string
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

}
