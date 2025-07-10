<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;


use App\Models\Riesgo;

class RiesgoController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $riesgos=Riesgo::all();
        return view('admin.ZonasRiesgo.index',compact('riesgos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.ZonasRiesgo.nuevo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos=[
            'nombre'=> $request->nombre,
            'descripcion'=> $request->descripcion,
            'nivel'=> $request->nivel,
            'latitud1'=> $request->latitud1,
            'longitud1'=> $request->longitud1,
            'latitud2'=> $request->latitud2,
            'longitud2'=> $request->longitud2,
            'latitud3'=> $request->latitud3,
            'longitud3'=> $request->longitud3,
            'latitud4'=> $request->latitud4,
            'longitud4'=> $request->longitud4
        ];
        Riesgo::create($datos);
         // Pasar mensaje a la vista con nombre 'message'
        return redirect()->route('ZonasRiesgo.index')->with('message', 'Zona creada exitosamente');
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
        //
        $riesgos = Riesgo::findOrFail($id); 
        return view('admin.ZonasRiesgo.editar', compact('riesgos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $riesgo = Riesgo::findOrFail($id);
        $riesgo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'nivel' => $request->nivel,
            'latitud1' => $request->latitud1,
            'longitud1' => $request->longitud1,
            'latitud2' => $request->latitud2,
            'longitud2' => $request->longitud2,
            'latitud3' => $request->latitud3,
            'longitud3' => $request->longitud3,
            'latitud4' => $request->latitud4,
            'longitud4' => $request->longitud4
        ]);

        return redirect()->route('ZonasRiesgo.index')->with('success', 'Zona actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $riegos = Riesgo::findOrFail($id);
        $riegos->delete();
    
        return redirect()->route('ZonasRiesgo.index')->with('success', 'Zona eliminada correctamente');
    }
    public function vistaReporte()
    {
        $riesgos = Riesgo::all(); 
        return view('admin.ZonasRiesgo.vista-reporte', compact('riesgos'));
    }

    public function generarReporte(Request $request)
    {
        $nivelSeleccionado = $request->input('nivelSeleccionado');

        $riesgos = ($nivelSeleccionado && $nivelSeleccionado !== 'Todos')
            ? Riesgo::where('nivel', $nivelSeleccionado)->get()
            : Riesgo::all();

        $urlReporte = route('zonas-riesgo.vista-reporte');

        $qrPng = \QrCode::format('png')
            ->size(120)
            ->generate($urlReporte);



        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrPng);
        $imagenMapa = $request->input('imagenMapa');

        return \PDF::loadView('admin.ZonasRiesgo.reporte-pdf', compact('riesgos', 'imagenMapa', 'qrBase64', 'nivelSeleccionado'))
            ->setPaper('A4', 'portrait')
            ->download('reporte_zonas_riesgo_' . now()->format('Ymd_His') . '.pdf');
    }



}
