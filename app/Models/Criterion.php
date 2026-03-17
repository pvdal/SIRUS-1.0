<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'unsatisfactory',
        'satisfactory',
        'good',
        'excellent',
        'criteria_type',
        'state',
    ];

    public function axes(): BelongsToMany
    {
        return $this->belongsToMany(Axis::class, 'axis_criteria', 'criteria_id', 'axis_id');
    }
}
