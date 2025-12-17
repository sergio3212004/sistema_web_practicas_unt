<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Mail\CodigoFichaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FichaCodigoController extends Controller
{
    //
    public function enviar()
    {
        $codigo = random_int(100000, 999999);

        session([
            'ficha_codigo' => $codigo,
            'ficha_codigo_expira' => now()->addMinutes(10)
        ]);

        Mail::to(Auth::user()->email)
            ->send(new CodigoFichaMail($codigo));

        return back()->with('success', 'Código enviado a tu correo electrónico');
    }
}
