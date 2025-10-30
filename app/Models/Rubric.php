<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rubric extends Model
{

    protected $fillable = ['name', 'type', 'state'];

    public function axis(): HasMany
    {
        return $this->hasMany(Axis::class,'rubric_id');
    }

    public function axes(): BelongsToMany
    {
        return $this->belongsToMany(Axis::class, 'rubric_axis', 'rubric_id', 'axis_id')
            ->withPivot('weight', 'type'); // Informa ao Eloquent para buscar os campos da tabela pivô
    }

    public function committees(): HasMany
    {
        return $this->HasMany(CommitteeRubric::class);
    }

    public function toFrontendStructure(): array
    {
        $this->load(['axes' => function($q) {
            // carregar criteria quando buscarmos axes
            $q->with(['criteria' => function($q2) {
                // carrega apenas campos necessários
                $q2->select('criteria.id', 'criteria.description', 'criteria.criteria_type');
            }]);
        }]);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'state' => $this->state,
            'axes' => $this->axes->map(function($axis) {
                // cada $axis tem ->pivot (rubric_axis) e ->criteria (collection)
                return [
                    'id' => $axis->id,
                    'name' => $axis->name,
                    'pivot' => [
                        'weight' => (float) $axis->pivot->weight,
                        'type' => $axis->pivot->type,
                    ],
                    // transform criteria para trazer weight do axis_criteria
                    'criteria' => $axis->criteria->map(function($crit) use ($axis) {
                        // o weight entre axis e criteria vem da pivot axis_criteria.
                        // quando usamos belongsToMany, o pivot estará em $crit->pivot
                        return [
                            'id' => $crit->id,
                            'description' => $crit->description,
                            'criteria_type' => $crit->criteria_type,
                            'weight' => isset($crit->pivot) ? (float) $crit->pivot->weight : null,
                        ];
                    })->values(),
                ];
            })->values(),
        ];
    }

}
