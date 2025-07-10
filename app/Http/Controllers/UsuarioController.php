<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZonaSegura;
use App\Models\Riesgo;


class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function inicio()
    {
        return view('user.inicio');
    }

    public function vistaReporte()
    {
        $zonas = ZonaSegura::all();
        return view('user.vista-reporte', compact('zonas'));
    }


    public function vistaReporteR()
    {
        $riesgos = Riesgo::all(); 
        return view('user.vista-riesgo', compact('riesgos'));
    }






    public function generarReporte(Request $request)
    {
        $tipoSeleccionado = $request->input('tipoSeleccionado');

        $zonas = ($tipoSeleccionado && $tipoSeleccionado !== 'Todos')
            ? ZonaSegura::where('tipo_seguridad', $tipoSeleccionado)->get()
            : ZonaSegura::all();

        $urlReporte = route('usuario-zonas-seguras.vista-reporte');

        $qrSvg = \QrCode::format('svg')
        ->size(120)
        ->generate($urlReporte);
    
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
        $imagenMapa = $request->input('imagenMapa');

        return \PDF::loadView('admin.ZonasSeguras.reporte-pdf', compact('zonas', 'imagenMapa', 'qrBase64', 'tipoSeleccionado'))
            ->setPaper('A4', 'portrait')
            ->download('reporte_zonas_seguras_' . now()->format('Ymd_His') . '.pdf');
    }


}
