<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    //
    protected $fillable = [
        'profesor_id',
        'aula_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Relación con Profesor
     */
    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    /**
     * Relación con Aula
     */
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    /**
     * Relación con los alumnos que han entregado
     */
    public function entregas_alumnos()
    {
        return $this->hasMany(EntregaAlumno::class);
    }

    /**
     * Alumnos que pertenecen a esta entrega
     */
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'entrega_alumno')
            ->withPivot('link_entrega', 'fecha_subida')
            ->withTimestamps();
    }
}
