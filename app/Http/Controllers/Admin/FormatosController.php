<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormatoOnce;
use App\Models\FormatoDoce;
use App\Models\Semestre;
use App\Models\Profesor;
use App\Models\Aula;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FormatosController extends Controller
{
    public function index(Request $request)
    {
        // Obtener parámetros de búsqueda
        $tipoFormato = $request->get('tipo_formato', 'all');
        $semestreId = $request->get('semestre_id');
        $busquedaProfesor = $request->get('busqueda_profesor');
        $aulaId = $request->get('aula_id');

        // Datos para los filtros
        $semestres = Semestre::orderBy('activo', 'desc')->orderBy('nombre', 'desc')->get();

        // Aulas filtradas dinámicamente
        $aulas = Aula::with('semestre', 'profesor')
            ->when($semestreId, function ($query) use ($semestreId) {
                return $query->where('semestre_id', $semestreId);
            })
            ->when($busquedaProfesor, function ($query) use ($busquedaProfesor) {
                return $query->whereHas('profesor', function ($q) use ($busquedaProfesor) {
                    $q->where('codigo_profesor', 'like', "%{$busquedaProfesor}%")
                        ->orWhere('nombres', 'like', "%{$busquedaProfesor}%")
                        ->orWhere('apellido_paterno', 'like', "%{$busquedaProfesor}%")
                        ->orWhere('apellido_materno', 'like', "%{$busquedaProfesor}%");
                });
            })
            ->orderBy('semestre_id', 'desc')
            ->orderBy('numero')
            ->get();

        // Query base para Formato 11
        $formatosOnce = null;
        if ($tipoFormato === 'all' || $tipoFormato === '11') {
            $formatosOnce = FormatoOnce::with([
                'aula.semestre',
                'aula.profesor',
                'formatoOnceAlumnos.alumno'
            ]);

            // Aplicar filtros
            $formatosOnce = $this->aplicarFiltros($formatosOnce, $semestreId, $busquedaProfesor, $aulaId);

            $formatosOnce = $formatosOnce->orderBy('id', 'desc')->paginate(10, ['*'], 'page_once');
        }

        // Query base para Formato 12
        $formatosDoce = null;
        if ($tipoFormato === 'all' || $tipoFormato === '12') {
            $formatosDoce = FormatoDoce::with([
                'aula.semestre',
                'aula.profesor',
                'formatosDoceAlumnos.alumno'
            ]);

            // Aplicar filtros
            $formatosDoce = $this->aplicarFiltros($formatosDoce, $semestreId, $busquedaProfesor, $aulaId);

            $formatosDoce = $formatosDoce->orderBy('id', 'desc')->paginate(10, ['*'], 'page_doce');
        }

        return view('admin.formatos.index', compact(
            'formatosOnce',
            'formatosDoce',
            'semestres',
            'aulas',
            'tipoFormato',
            'semestreId',
            'busquedaProfesor',
            'aulaId'
        ));
    }

    /**
     * Aplicar filtros comunes a ambos tipos de formato
     */
    private function aplicarFiltros($query, $semestreId, $busquedaProfesor, $aulaId)
    {
        // Filtro por semestre
        if ($semestreId) {
            $query->whereHas('aula', function ($q) use ($semestreId) {
                $q->where('semestre_id', $semestreId);
            });
        }

        // Filtro por profesor (código o nombre)
        if ($busquedaProfesor) {
            $query->whereHas('aula.profesor', function ($q) use ($busquedaProfesor) {
                $q->where('codigo_profesor', 'like', "%{$busquedaProfesor}%")
                    ->orWhere('nombres', 'like', "%{$busquedaProfesor}%")
                    ->orWhere('apellido_paterno', 'like', "%{$busquedaProfesor}%")
                    ->orWhere('apellido_materno', 'like', "%{$busquedaProfesor}%");
            });
        }

        // Filtro por aula específica
        if ($aulaId) {
            $query->where('aula_id', $aulaId);
        }

        return $query;
    }

    /**
     * Mostrar detalle del Formato 11
     */
    public function showFormatoOnce(FormatoOnce $formatoOnce)
    {
        $formatoOnce->load(['aula.semestre', 'aula.profesor', 'formatoOnceAlumnos.alumno']);

        return view('admin.formatos.show-once', compact('formatoOnce'));
    }

    /**
     * Mostrar detalle del Formato 12
     */
    public function showFormatoDoce(FormatoDoce $formatoDoce)
    {
        $formatoDoce->load(['aula.semestre', 'aula.profesor', 'formatosDoceAlumnos.alumno']);

        return view('admin.formatos.show-doce', compact('formatoDoce'));
    }

    /**
     * Generar PDF del Formato 11
     */
    public function pdfFormatoOnce(FormatoOnce $formatoOnce)
    {
        $formatoOnce->load(['aula.semestre', 'aula.profesor', 'formatoOnceAlumnos.alumno.fichaActual']);

        $pdf = Pdf::loadView('profesor.formato-once.pdf', compact('formatoOnce'));
        $pdf->setPaper('A4', 'landscape');

        $fileName = 'Formato_11_Aula_' . $formatoOnce->aula->numero . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Generar PDF del Formato 12
     */
    public function pdfFormatoDoce(FormatoDoce $formatoDoce)
    {
        $formatoDoce->load(['aula.semestre', 'aula.profesor', 'formatosDoceAlumnos.alumno.fichaActual']);

        $pdf = Pdf::loadView('admin.formatos.pdf-doce', compact('formatoDoce'));
        $pdf->setPaper('A4', 'landscape');

        $fileName = 'Formato_12_Aula_' . $formatoDoce->aula->numero . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($fileName);
    }
}
