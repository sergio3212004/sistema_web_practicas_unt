<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\SolicitudEmpresa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AprobacionController extends Controller
{
    //
    public function index()
    {
        // Obtener solicitudes con email verificado y estado pendiente
        $solicitudesPendientes = SolicitudEmpresa::with('razonSocial')
            ->pendientes()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.aprobaciones.index', compact('solicitudesPendientes'));
    }

    /**
     * Aprobar una solicitud de empresa - CREAR el usuario y la empresa
     */
    public function aprobar($id)
    {
        $solicitud = SolicitudEmpresa::findOrFail($id);

        // Verificar que la solicitud esté pendiente y con email verificado
        if ($solicitud->estado !== 'pendiente' || !$solicitud->email_verificado) {
            return redirect()->route('admin.aprobaciones.index')
                ->with('error', 'Esta solicitud no puede ser aprobada.');
        }

        DB::beginTransaction();

        try {
            // AHORA sí crear el usuario
            $user = User::create([
                'email' => $solicitud->email,
                'password' => $solicitud->password, // Ya está hasheado
                'rol_id' => 4, // Rol de empresa
            ]);

            // Crear el perfil de empresa
            $empresa = Empresa::create([
                'ruc' => $solicitud->ruc,
                'nombre' => $solicitud->nombre,
                'user_id' => $user->id,
                'razon_social_id' => $solicitud->razon_social_id,
                'telefono' => $solicitud->telefono,
                'departamento' => $solicitud->departamento,
                'provincia' => $solicitud->provincia,
                'distrito' => $solicitud->distrito,
                'direccion' => $solicitud->direccion,
            ]);

            // Marcar solicitud como aprobada
            $solicitud->update(['estado' => 'aprobado']);

            // Disparar evento de registro
            event(new Registered($user));

            DB::commit();

            return redirect()->route('admin.aprobaciones.index')
                ->with('success', "Empresa '{$solicitud->nombre}' aprobada exitosamente. El usuario ya puede iniciar sesión.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.aprobaciones.index')
                ->with('error', "Error al aprobar la empresa: " . $e->getMessage());
        }
    }

    /**
     * Rechazar una solicitud de empresa
     */
    public function rechazar(Request $request, $id)
    {
        $solicitud = SolicitudEmpresa::findOrFail($id);

        // Verificar que la solicitud esté pendiente
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('admin.aprobaciones.index')
                ->with('error', 'Esta solicitud ya fue procesada.');
        }

        $nombreEmpresa = $solicitud->nombre;

        // Marcar como rechazada (opcionalmente con motivo)
        $solicitud->update([
            'estado' => 'rechazado',
            'motivo_rechazo' => $request->input('motivo', 'Solicitud rechazada por el administrador'),
        ]);

        // Opción: Eliminar la solicitud completamente
        // $solicitud->delete();

        return redirect()->route('admin.aprobaciones.index')
            ->with('success', "Solicitud de '{$nombreEmpresa}' rechazada.");
    }
}
