<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoFicha extends Model
{
    //
    protected $table = 'codigo_fichas';

    protected $fillable = [
        'alumno_id',
        'codigo',
        'expires_at',
        'usado'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'usado' => 'boolean'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function estaVigente()
    {
        return !$this->usado && $this->expires_at->isFuture();
    }
}
