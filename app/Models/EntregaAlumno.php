<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaAlumno extends Model
{
    //
    protected $table = 'entrega_alumno';

    protected $fillable = [
        'entrega_id',
        'alumno_id',
        'link_entrega',
        'fecha_subida'
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
