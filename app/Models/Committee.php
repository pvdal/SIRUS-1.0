<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\HigherOrderCollectionProxy;

class Committee extends Model
{
    /**
     * @var HigherOrderCollectionProxy|mixed
     */
    protected $fillable = [
        'name',
        'coordinator_id',
        'rubric_id',
        'paper_id',
        'corrected_paper_id',
        'start',
        'end',
        'state',
        'presentation_time',
        'evaluation_time',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'start' => 'datetime',
        'end' => 'datetime',
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
        return $this->belongsTo(Paper::class, 'paper_id');
    }

    public function correctedPaper(): BelongsTo
    {
        return $this->belongsTo(Paper::class, 'corrected_paper_id');
    }

    // Relacionamento com Rubric
    public function rubrics(): HasMany
    {
        return $this->HasMany(CommitteeRubric::class);
    }
    #endregion
}
