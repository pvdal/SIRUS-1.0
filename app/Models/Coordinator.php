<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Coordinator extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    #region Relacionamentos
    // Relacionamento com o User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o Course
    public function course(): HasOne
    {
        return $this->hasOne(Course::class);
    }

    public function committee(): HasMany
    {
        return $this->hasMany(Committee::class);
    }
    #endregion
}
