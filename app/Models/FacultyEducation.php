<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FacultyEducation extends Model
{
    protected $fillable = [
        'user_id',
        'level',
        'course',
        'institution',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento com User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
