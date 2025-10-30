<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class GroupEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_id',
        'user_committee_id',
        'grade',
        'comment',
    ];

    public function criterion(): belongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    public function userCommittee(): belongsTo
    {
        return $this->belongsTo(UserCommittee::class);
    }
}
