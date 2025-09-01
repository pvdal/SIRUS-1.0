<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProfessorCommittee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Committee extends Model
{
    protected $fillable = [
        'name',
        'coordinator_id',
        'group_id',
        'rubric_id',
        'paper_id',
        'event_id',
        'state'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relacionamento com ProfessorCommittee
    public function members(): HasMany
    {
        return $this->hasMany(ProfessorCommittee::class);
    }

    // Relacionamento com Coordinator
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(Coordinator::class);
    }

    // Relacionamento com Group
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    // Relacionamento com Paper
    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class);
    }

    // Relacionamento com Event
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
