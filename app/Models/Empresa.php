<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //
    protected $table = 'empresas';
    protected $fillable = [
        'ruc',
        'nombre',
        'user_id',
        'nombre',
        'telefono',
        'departamento',
        'provincia',
        'distrito',
        'direccion',
        'codigo_verificacion',
        'email_verificado',
        'razon_social_id',
        'aprobado'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function razonSocial() {
        return $this->belongsTo(RazonSocial::class, 'razon_social_id', 'id');
    }

    public function publicacion() {
        return $this->hasMany(Publicacion::class, 'empresa_id', 'id');
    }
}
