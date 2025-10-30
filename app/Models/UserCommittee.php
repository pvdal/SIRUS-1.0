<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserCommittee extends Model
{
    protected $fillable = [
        'user_id',
        'committee_id',
        'member_type_id',
        'evaluated_at',
        'state'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'evaluated_at' => 'datetime',
    ];

    #region Relacionamentos
    // Relacionamento com Committee
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    // Relacionamento com membro
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com MemberType
    public function memberType(): BelongsTo
    {
        return $this->belongsTo(MemberType::class, 'member_type_id');
    }

    // Relacionamento com Paper
    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class);
    }
    #endregion


    //Cada registro de avaliação pode ter várias avaliações em grupo.
    public function groupEvaluations(): HasMany
    {
        return $this->hasMany(GroupEvaluation::class);
    }



    //Este registro de avaliação pode ter várias avaliações individuais.

    public function individualEvaluations(): HasMany
    {
        return $this->hasMany(IndividualEvaluation::class);
    }

}
