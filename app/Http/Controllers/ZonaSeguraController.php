<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZonaSegura;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;






class ZonaSeguraController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zonas = ZonaSegura::all();
        return view('admin.ZonasSeguras.index', compact('zonas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ZonasSeguras.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'radio' => 'required|numeric|min:1',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
            'tipo_seguridad' => 'required|string|max:100',
        ]);

        ZonaSegura::create([
            'nombre' => $request->nombre,
            'radio' => $request->radio,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'tipo_seguridad' => $request->tipo_seguridad,
        ]);

        return redirect()->route('zonas-seguras.index')
            ->with('success', 'Zona segura registrada correctamente ✅');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $zona = ZonaSegura::findOrFail($id);
        return view('admin.ZonasSeguras.editar', compact('zona'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $zona = ZonaSegura::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_seguridad' => 'required|string|max:100',
            'radio' => 'required|numeric|min:1',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);

        $zona->update([
            'nombre' => $request->nombre,
            'tipo_seguridad' => $request->tipo_seguridad,
            'radio' => $request->radio,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ]);

        return redirect()->route('zonas-seguras.index')
            ->with('success', 'Zona segura actualizada correctamente ✅');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $zona = ZonaSegura::findOrFail($id);
        $zona->delete();

        return redirect()->route('zonas-seguras.index')
            ->with('success', 'Zona eliminada correctamente ✅');
    }



    //FUNCION PARA LA GENERACION DE REPORTES

public function vistaReporte()
{
    $zonas = ZonaSegura::all();
    return view('admin.ZonasSeguras.vista-reporte', compact('zonas'));
}



public function generarReporte(Request $request)
{
    $zonas = ZonaSegura::all();

    // 1. Generar código QR
    $qrPng = QrCode::format('png')
        ->size(120)
        ->generate(route('zonas-seguras.vista-reporte'));

    $qrBase64 = 'data:image/png;base64,' . base64_encode($qrPng);

    // 2. Agrupar marcadores por tipo de seguridad (colores personalizados)
    $colores = [
        'refugio' => 'red',
        'evacuacion' => 'green',
        'centro_salud' => 'blue'
    ];

    $marcadoresPorTipo = '';
    foreach ($colores as $tipo => $color) {
        $grupo = $zonas->where('tipo_seguridad', $tipo)->map(fn($z) => "{$z->latitud},{$z->longitud}")->implode('|');
        if ($grupo) {
            $marcadoresPorTipo .= "&markers=color:{$color}|" . urlencode($grupo);
        }
    }

    // 3. Generar URL del mapa estático
    $mapUrl = "https://maps.googleapis.com/maps/api/staticmap?"
            . "size=600x400"
            . "&zoom=10"
            . "&maptype=roadmap"
            . $marcadoresPorTipo
            . "&key=AIzaSyA9nnzLcrO4AqCmrDpuYGAToZXbidJcrlo";

    // 4. Obtener imagen desde Google y codificarla
    $mapImage = Http::get($mapUrl)->body();
    $mapBase64 = 'data:image/png;base64,' . base64_encode($mapImage);

    // 5. Generar y descargar PDF
    return Pdf::loadView('admin.ZonasSeguras.reporte-pdf', compact('zonas', 'mapBase64', 'qrBase64'))
              ->setPaper('A4', 'portrait')
              ->download('reporte_zonas_seguras_' . now()->format('Ymd_His') . '.pdf');
}



public function mostrarMapa()
{
    $zonas = ZonaSegura::all();
    $marcadores = '';

    foreach ($zonas as $zona) {
        if ($zona->latitud && $zona->longitud) {
            $latLng = "{$zona->latitud},{$zona->longitud}";
            $marcadores .= "&markers=color:red|" . urlencode($latLng);
        }
    }

    $mapUrl = "https://maps.googleapis.com/maps/api/staticmap?"
            . "size=600x400"
            . "&zoom=10"
            . "&maptype=roadmap"
            . $marcadores
            . "&key=" . env('GOOGLE_MAPS_KEY'); // Usa tu .env para seguridad

    $response = Http::get($mapUrl);

    if (!$response->successful()) {
        return response("No se pudo generar el mapa. Código: " . $response->status(), 500);
    }

    return response($response->body(), 200)
        ->header('Content-Type', 'image/png');
}





}
