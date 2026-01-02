<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaAlumno extends Model
{
    //
    protected $table = 'entrega_alumnos';

    protected $fillable = [
        'entrega_id',
        'alumno_id',
        'link_entrega',
        'fecha_subida',
        'comentario_profesor',
        'nota',
        'fecha_revision'
    ];

    protected $casts = [
        'fecha_subida' => 'datetime',
    ];

    /**
     * Relación con Entrega
     */
    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }

    /**
     * Relación con Alumno
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
