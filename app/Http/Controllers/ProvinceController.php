<?php

namespace App\Http\Controllers;

use App\Models\Province;

use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::all();
        return view('province.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('province.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NombreProvincia' => 'required|string|max:100|unique:Provincia,NombreProvincia',
            'Capital' => 'required|string|max:100',
            'Poblacion' => 'required|integer|min:1',
            'ClimaPredominante' => 'required|string|max:100',
        ], [
            'NombreProvincia.unique' => 'El nombre de la provincia ya existe.',
            'NombreProvincia.required' => 'El nombre es obligatorio.',
        ]);

        Province::create($request->all());

        return redirect()->route('provinces.index')
                        ->with('success', 'Provincia registrada correctamente');
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
        $province = Province::findOrFail($id);
        return view('province.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $province = Province::findOrFail($id);

        $request->validate([
            'NombreProvincia' => 
                'required|string|max:100|unique:Provincia,NombreProvincia,' . 
                $province->IdProvincia . ',IdProvincia',
            'Capital' => 'required|string|max:100',
            'Poblacion' => 'required|integer|min:1',
            'ClimaPredominante' => 'required|string|max:100',
        ], [
            'NombreProvincia.unique' => 'Ya existe otra provincia con ese nombre.',
        ]);

        $province->update($request->all());

        return redirect()->route('provinces.index')
                        ->with('success', 'Provincia actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $province = Province::findOrFail($id);

        // Validar si hay zonas asociadas
        if ($province->zones()->count() > 0) {
            return redirect()->route('provinces.index')
                ->with('error', 'No se puede eliminar la provincia porque está asociada a uno o más lugares turísticos.');
        }

        $province->delete();

        return redirect()->route('provinces.index')
            ->with('success', 'Provincia eliminada correctamente.');
    }
}
