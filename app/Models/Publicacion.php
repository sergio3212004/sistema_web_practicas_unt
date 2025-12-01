<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    //
    protected $table = 'publicaciones';
    protected $fillable = [
        'nombre',
        'empresa_id',
        'descripcion',
        'fecha',
        'imagen'
    ];

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }
}
