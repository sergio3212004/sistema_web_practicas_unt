<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Mail\SolicitudFirmaEmpresaMail;
use App\Mail\SolicitudFirmaProgramaMail;
use App\Models\FichaRegistro;
use App\Models\CodigoFicha;
use App\Models\FichaRegistroHorario;
use App\Models\RazonSocial;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\FirmaToken;
use Illuminate\Support\Facades\Storage;

class FichaRegistroController extends Controller
{
    /**
     * Listar fichas del alumno
     */
    public function index()
    {
        $alumno = Auth::user()->alumno;

        $ficha = FichaRegistro::with('cronograma')
            ->where('alumno_id', $alumno->id)
            ->first();

        return view('alumno.ficha-registro.index', compact('ficha'));
    }

    /**
     * Crear ficha (requiere código validado en sesión)
     */
    public function create(Request $request)
    {
        $alumno = Auth::user()->alumno;
        $semestreActual = Semestre::where('activo', true)->firstOrFail();
        $razonesSociales = RazonSocial::orderBy('acronimo')->get();

        return view('alumno.ficha-registro.create', compact(
            'alumno',
            'semestreActual',
            'razonesSociales'
        ));
    }

    /**
     * Formulario para ingresar código
     */
    public function formVerificarCodigo()
    {
        $alumno = Auth::user()->alumno;

        // Evitar reenviar múltiples veces
        if (!session()->has('codigo_ficha_enviado')) {

            $codigo = random_int(100000, 999999);

            CodigoFicha::create([
                'alumno_id' => $alumno->id,
                'codigo' => $codigo,
                'expires_at' => now()->addMinutes(10),
                'usado' => false
            ]);

            Mail::to(Auth::user()->email)
                ->send(new \App\Mail\CodigoFichaMail($codigo));

            session(['codigo_ficha_enviado' => true]);
        }

        return view('alumno.ficha-registro.verificar-codigo');
    }

    /**
     * Verificar código ingresado
     */
    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|digits:6'
        ]);

        $alumno = Auth::user()->alumno;

        $codigo = CodigoFicha::where('alumno_id', $alumno->id)
            ->where('codigo', $request->codigo)
            ->where('usado', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$codigo) {
            return back()->withErrors([
                'codigo' => 'Código inválido o expirado'
            ]);
        }

        // Marcar como usado
        $codigo->update(['usado' => true]);

        // Validar sesión
        session(['codigo_ficha_validado' => true]);

        return redirect()
            ->route('alumno.ficha.create')
            ->with('success', 'Código verificado correctamente');
    }
    public function store(Request $request)
    {
        $alumno = Auth::user()->alumno;

        $request->validate([
            'ciclo' => 'required|integer|min:1|max:10',
            'semestre_id' => 'required|exists:semestres,id',
            'razon_social_id' => 'required|exists:razones_sociales,id',
            'ruc' => 'required|digits:11',
            'correo_empresa' => 'required|email',
            'nombre_empresa' => 'required|string|max:255', // ✅
            'nombre_gerente' => 'required|string|max:255',
            'nombre_jefe_rrhh' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono_fijo' => 'required|string|max:20',
            'telefono_movil' => 'required|string|max:20',
            'departamento' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'distrito' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after:fecha_inicio',
            'descripcion' => 'required|string',
            'area_practicas' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'nombre_jefe_directo' => 'required|string|max:255',
            'telefono_jefe_directo' => 'required|string|max:20',
            'correo_jefe_directo' => 'required|email',
            'firma_practicante' => 'required|string',
            'horarios' => 'required|array|min:1'
        ]);

        DB::transaction(function () use ($request, $alumno) {

            /** --------------------------------
             * OBTENER RAZÓN SOCIAL
             * -------------------------------- */
            $razonSocial = \App\Models\RazonSocial::findOrFail($request->razon_social_id);

            $razonSocialCompleta = trim(
                $request->nombre_empresa . ' ' . $razonSocial->acronimo
            );

            /** -------------------------
             * GUARDAR FIRMA DEL ALUMNO
             * ------------------------- */
            $firmaBase64 = $request->firma_practicante;
            $firmaBase64 = str_replace('data:image/png;base64,', '', $firmaBase64);
            $firmaBase64 = str_replace(' ', '+', $firmaBase64);

            $nombreFirma = 'firma_alumno_' . $alumno->id . '_' . time() . '.png';
            Storage::disk('public')->put('firmas/' . $nombreFirma, base64_decode($firmaBase64));

            /** -------------------------
             * CREAR FICHA
             * ------------------------- */
            $ficha = FichaRegistro::create([
                'alumno_id' => $alumno->id,
                'ciclo' => $request->ciclo,
                'semestre_id' => $request->semestre_id,
                'razon_social' => $razonSocialCompleta,
                'ruc' => $request->ruc,
                'correo_empresa' => $request->correo_empresa,
                'nombre_gerente' => $request->nombre_gerente,
                'nombre_jefe_rrhh' => $request->nombre_jefe_rrhh,
                'direccion' => $request->direccion,
                'telefono_fijo' => $request->telefono_fijo,
                'telefono_movil' => $request->telefono_movil,
                'departamento' => $request->departamento,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_termino' => $request->fecha_termino,
                'descripcion' => $request->descripcion,
                'area_practicas' => $request->area_practicas,
                'cargo' => $request->cargo,
                'nombre_jefe_directo' => $request->nombre_jefe_directo,
                'telefono_jefe_directo' => $request->telefono_jefe_directo,
                'correo_jefe_directo' => $request->correo_jefe_directo,
                'firma_practicante' => $nombreFirma,
                'aceptado' => false
            ]);

            /** -------------------------
             * GUARDAR HORARIOS
             * ------------------------- */
            foreach ($request->horarios as $horario) {
                FichaRegistroHorario::create([
                    'ficha_registro_id' => $ficha->id,
                    'dia_semana' => $horario['dia_semana'],
                    'hora_inicio' => $horario['hora_inicio'],
                    'hora_fin' => $horario['hora_fin'],
                ]);
            }


            // ==========================
            // GENERAR TOKENS DE FIRMA
            // ==========================

            // Empresa
            $tokenEmpresa = FirmaToken::create([
                'ficha_registro_id' => $ficha->id,
                'email' => $request->correo_empresa,
                'tipo' => 'empresa',
                'token' => Str::uuid(),
                'expires_at' => now()->addDays(7),
            ]);

            // Jefe directo
            $tokenJefe = FirmaToken::create([
                'ficha_registro_id' => $ficha->id,
                'email' => $request->correo_jefe_directo,
                'tipo' => 'jefe_directo',
                'token' => Str::uuid(),
                'expires_at' => now()->addDays(7),
            ]);

            Mail::to($tokenEmpresa->email)
                ->send(new SolicitudFirmaEmpresaMail($tokenEmpresa));
            Mail::to($tokenJefe->email)
                ->send(new SolicitudFirmaProgramaMail($tokenJefe));
        });


        // Limpiar sesión de código
        session()->forget('codigo_ficha_validado');

        return redirect()
            ->route('alumno.ficha.index')
            ->with('success', 'Ficha registrada correctamente. Las firmas han sido solicitadas.');
    }

    public function show(FichaRegistro $fichaRegistro) {
        if ($fichaRegistro->alumno_id !== auth()->user()->alumno->id) {
            abort(403);
        }

        // Cargar relaciones necesarias
        $fichaRegistro->load([
            'horarios',
            'firmaTokens', // si los tienes
        ]);

        return view('alumno.ficha.show', compact('fichaRegistro'));
    }

}
