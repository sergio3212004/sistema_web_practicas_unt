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

    public function fichasRegistro()
    {
        return $this->hasMany(\App\Models\FichaRegistro::class, 'alumno_id');
    }


    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";
    }

}
