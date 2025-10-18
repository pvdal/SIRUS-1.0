<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Axis extends Model
{
    /**
     * @var bool|mixed
     */
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'amount',
        'state',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];




    /**
     * Define a relação de muitos-para-muitos com o model Criterion.
     * Um Eixo pode ter vários Critérios.
     */
    // relação many-to-many com criteria via axis_criteria (pivot com weight)

    public function criteria(): BelongsToMany
    {
        return $this->belongsToMany(Criterion::class, 'axis_criteria', 'axis_id', 'criteria_id');
    }

    /**
     * Accessor para o atributo 'amount'.
     *
     * Este método é chamado automaticamente quando tentamos acessar a propriedade 'amount'.
     * Ele calcula a contagem de critérios relacionados.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */



}
