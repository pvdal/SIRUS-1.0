<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'start',
        'end',
        'color',
        'state'
    ];

    public function professor_committee(): HasMany
    {
        return $this->hasMany(ProfessorCommittee::class);
    }
}
