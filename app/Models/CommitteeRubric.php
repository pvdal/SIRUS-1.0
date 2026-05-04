<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CommitteeRubric extends Pivot
{
    protected $table = 'committee_rubrics';

    protected $fillable = [
        'committee_id',
        'rubric_id',
        'weight',
        'state',
    ];

    protected $casts = [
        'state' => 'boolean',
    ];

    #region Relacionamentos
    // Relacionamento com Rubric
    public function rubric(): BelongsTo
    {
        return $this->belongsTo(Rubric::class);
    }

    // Relacionamento com Committee
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }
    #endregion
}

