<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Committee extends Model
{
    protected $fillable = [
        'name',
        'coordinator_id',
        'rubric_id',
        'paper_id',
        'state'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    #region Relacionamentos
    // Relacionamento com UserCommittee
    public function members(): HasMany
    {
        return $this->hasMany(UserCommittee::class);
    }

    // Relacionamento com Coordinator
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(Coordinator::class);
    }

    // Relacionamento com ‘Paper’
    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class);
    }
    #endregion
}
