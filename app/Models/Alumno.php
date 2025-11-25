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
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
