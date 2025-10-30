<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;
    protected $primaryKey = 'ra'; // Chave primária personalizada (string)
    public $incrementing = false; // Impede autoincremento
    protected $keyType = 'string'; // Define como string

    // Campos que serão aceitos por esse model usando os métodos eloquent
    protected $fillable = [
        'ra',
        'user_id',
        'course_id',
        'group_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    #region Relacionamentos
    // Relacionamento com User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Relacionamento com Course
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    // Relacionamento com Group
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class,'group_id');
    }
    // Relacionamento com IndividualEvaluation
    public function individualEvaluations(): hasMany
    {
        return $this->hasMany(IndividualEvaluation::class, 'ra', 'ra');
    }
    #endregion
}
