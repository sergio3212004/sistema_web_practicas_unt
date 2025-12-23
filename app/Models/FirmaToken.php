<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmaToken extends Model
{
    //
    protected $table = 'firma_tokens';

    protected $fillable = [
        'ficha_registro_id',
        'email',
        'tipo',
        'token',
        'expires_at',
        'signed_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'signed_at' => 'datetime',
    ];

    public function ficha()
    {
        return $this->belongsTo(FichaRegistro::class, 'ficha_registro_id');
    }
}
