<?php

namespace App\Http\Controllers;
use App\Models\Type;

use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();
        return view('type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('type.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
            'NombreTipoAtraccion' => 'required|string|max:150|unique:TipoAtraccion,NombreTipoAtraccion',
            'NivelPopularidad'    => 'required|string|max:150',
            'RequiereGuia'        => 'required|string|max:150',
        ], [
            'NombreTipoAtraccion.unique' => 'El tipo de atracción ya existe.',
            'NombreTipoAtraccion.required' => 'El nombre del tipo es obligatorio.',
        ]);

        Type::create($request->all());

        return redirect()->route('types.index')
                        ->with('success', 'Tipo de atracción creado correctamente');

        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $type = Type::findOrFail($id);
        return view('type.update', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = Type::findOrFail($id);
        return view('type.update', compact('type'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = Type::findOrFail($id);

            $request->validate([
                'NombreTipoAtraccion' => 
                    'required|string|max:150|unique:TipoAtraccion,NombreTipoAtraccion,' . 
                    $type->IdTipoAtraccion . ',IdTipoAtraccion',
                'NivelPopularidad' => 'required|string|max:150',
                'RequiereGuia'     => 'required|string|max:150',
            ], [
                'NombreTipoAtraccion.unique' => 'Ya existe otro tipo con ese nombre.',
            ]);

            $type->update($request->all());

            return redirect()->route('types.index')
                            ->with('success', 'Tipo de atracción actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = Type::findOrFail($id);

        if ($type->zones()->count() > 0) {
            return redirect()->route('types.index')
                ->with('error', 'No se puede eliminar este tipo porque está asociado a uno o más lugares turísticos.');
        }

        $type->delete();

        return redirect()->route('types.index')
            ->with('success', 'Tipo de atracción eliminado correctamente.');
    }
}
