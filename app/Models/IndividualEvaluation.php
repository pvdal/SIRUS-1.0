<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualEvaluation extends Model
{
    protected $fillable = [
        'user_committee_id',
        'ra',
        'criteria_id',
        'grade',
        'comment',
    ];

    public function userCommittee(): belongsTo
    {
        return $this->belongsTo(UserCommittee::class, 'user_committee_id');
    }

    public function student(): belongsTo
    {
        // Relacionamento baseado na chave 'ra'
        return $this->belongsTo(Student::class, 'ra', 'ra');
    }

    public function criterion(): belongsTo
    {
        return $this->belongsTo(Criterion::class, 'criteria_id');
    }
}
