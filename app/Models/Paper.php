<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paper extends Model
{
    protected $fillable = [
        'title',
        'group_id',
        'file_path',
        'submitted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    #region Relacionamentos
    // Relacionamento com Group
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    // Relacionamento com Committee
    public function committee(): HasOne
    {
        return $this->hasOne(Committee::class);
    }
    #endregion
}
