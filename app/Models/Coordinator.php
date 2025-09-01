<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coordinator extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento com o User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o Course
    public function course()
    {
        return $this->hasOne(Course::class);
    }

    public function committee(): HasMany
    {
        return $this->hasMany(Committee::class);
    }
}
