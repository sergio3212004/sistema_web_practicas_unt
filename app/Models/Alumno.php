<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    //
    protected $table = 'alumnos';

    protected $fillable = [
        'codigo_matricula',
        'user_id',
        'aula_id',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'cv'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con aula
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function fichaRegistro()
    {
        return $this->hasOne(\App\Models\FichaRegistro::class, 'alumno_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    public function fichaActual()
    {
        return $this->hasOne(\App\Models\FichaRegistro::class, 'alumno_id')
            ->latestOfMany();
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }

    public function postualaciones() {
        return $this->hasMany(Postulacion::class);
    }

    public function formatoOnceAlumnos() {
        return $this->hasMany(FormatoOnceAlumno::class, 'alumno_id', 'id');
    }

}
