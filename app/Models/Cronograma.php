<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    //
    protected $fillable = [
        'ficha_id',
        'firma_practicante_at',
        'firma_jefe_directo_at',
        'firma_profesor_at',
    ];

    protected $casts = [
        'firma_practicante_at' => 'datetime',
        'firma_jefe_directo_at' => 'datetime',
        'firma_profesor_at' => 'datetime',
    ];

    public function fichaRegistro()
    {
        return $this->belongsTo(FichaRegistro::class, 'ficha_id');
    }

    public function actividades()
    {
        return $this->hasMany(\App\Models\CronogramaActividad::class, 'cronograma_id');
    }


    public function firmaTokens()
    {
        return $this->hasMany(FirmaToken::class, 'ficha_registro_id', 'ficha_registro_id')
            ->where('contexto', 'cronograma');
    }

    // Helpers útiles
    public function estaFirmadoCompleto(): bool
    {
        return $this->firma_practicante_at
            && $this->firma_jefe_directo_at
            && $this->firma_profesor_at;
    }

    public function estaPendienteFirmaJefe(): bool
    {
        return !$this->firma_jefe_directo_at;
    }

    public function estaPendienteFirmaProfesor(): bool
    {
        return !$this->firma_profesor_at;
    }
}
