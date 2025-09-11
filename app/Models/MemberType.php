<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberType extends Model
{
    protected $fillable = [
        'name',
        'state'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function UserCommittee(): HasMany
    {
        return $this->hasMany(UserCommittee::class);
    }
}
