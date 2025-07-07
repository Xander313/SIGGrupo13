<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZonaSegura;



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

}
