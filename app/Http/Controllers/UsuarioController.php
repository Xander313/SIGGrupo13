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
        return view('user.inicio'); //bienvenida
    }

    public function vistaReporte()
    {
        $zonas = ZonaSegura::all();
        return view('user.vista-report', compact('zonas')); // reporte previo para zonas segurea

    }
    public function vistaReporteR()
    {
        $zonas = Riesgo::all();
        return view('user.vista-riesgo', compact('zonas')); // reporte previo para zonas ded riesgo

    }







    public function generarReporte(Request $request)
    {
        $zonas = ZonaSegura::all();

        // ✅ URL dinámica del reporte
        $urlReporte = route('usuario-zonas-seguras.vista-reporte'); // genera la URL completa según el dominio

        // ✅ Generar QR con la URL real del entorno
        $qrPng = \QrCode::format('png')
            ->size(120)
            ->generate($urlReporte);

        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrPng);

        // Lógica para imagen del mapa desde frontend
        $imagenMapa = $request->input('imagenMapa');

        return \PDF::loadView('admin.ZonasSeguras.reporte-pdf', compact('zonas', 'imagenMapa', 'qrBase64'))
            ->setPaper('A4', 'portrait')
            ->download('reporte_zonas_seguras_' . now()->format('Ymd_His') . '.pdf');
    }

    ///ZONAS DE RIESGO////
    public function generarReporteR(Request $request)

    {
        $riesgos = ZonasRiesgo::all(); // Modelo correspondiente

        // URL dinámica del reporte
        $urlReporte = route('usuario-zonas-riesgo.vista-reporte'); // Asegúrate que esta ruta esté definida

        // ✅ Generar QR con la URL del entorno
        $qrPng = \QrCode::format('png')
            ->size(120)
            ->generate($urlReporte);

        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrPng);

        // Lógica para imagen del mapa capturada desde el frontend
        $imagenMapa = $request->input('imagenMapa');

        return \PDF::loadView('admin.ZonasRiesgo.reporte-pdf', compact('riesgos', 'imagenMapa', 'qrBase64'))
            ->setPaper('A4', 'portrait')
            ->download('reporte_zonas_riesgo_' . now()->format('Ymd_His') . '.pdf');
    }


}
