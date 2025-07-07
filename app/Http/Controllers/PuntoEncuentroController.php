<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuntoEncuentro;

class PuntoEncuentroController extends Controller
{
    public function index()
    {
        $puntos = PuntoEncuentro::all();
        return view('admin.puntosEncuentro.index', compact('puntos'));
    }

    public function create()
    {
        return view('admin.puntosEncuentro.nuevo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'capacidad' => 'required|integer|min:1',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'responsable' => 'required|max:100'
        ]);

        PuntoEncuentro::create($request->all());

        return redirect()->route('puntos-encuentro.index')
            ->with('success', 'Punto de encuentro creado exitosamente');
    }

    public function show($id)
    {
        $punto = PuntoEncuentro::findOrFail($id);
        return view('admin.puntosEncuentro.mostrar', compact('punto'));
    }

    public function edit($id)
    {
        $punto = PuntoEncuentro::findOrFail($id);
        return view('admin.puntosEncuentro.editar', compact('punto'));
    }

    public function update(Request $request, $id)
    {
        $punto = PuntoEncuentro::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|max:100',
            'capacidad' => 'required|integer|min:1',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'responsable' => 'required|max:100'
        ]);

        $punto->update($request->all());

        return redirect()->route('puntos-encuentro.index')
            ->with('success', 'Punto de encuentro actualizado exitosamente');
    }

    public function destroy($id)
    {
        $punto = PuntoEncuentro::findOrFail($id);
        $punto->delete();

        return redirect()->route('puntos-encuentro.index')
            ->with('success', 'Punto de encuentro eliminado exitosamente');
    }
}
