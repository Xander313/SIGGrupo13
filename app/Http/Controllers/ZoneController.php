<?php

namespace App\Http\Controllers;
use App\Models\Zone;
use App\Models\Province;
use App\Models\Type;


use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::with(['province', 'type'])->get();
        return view('zone.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();
        $types = Type::all();

        return view('zone.new', compact('provinces', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Zone::create($request->all());

        return redirect()->route('zones.index')
                     ->with('success', 'Lugar turístico registrado correctamente');
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
        $zone = Zone::findOrFail($id);
        $provinces = Province::all();
        $types = Type::all();

        return view('zone.update', compact('zone', 'provinces', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $zone = Zone::findOrFail($id);

        $zone->update($request->all());

        return redirect()->route('zones.index')
                        ->with('success', 'Lugar Turístico actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $zone = Zone::findOrFail($id);
        $zone->delete();

        return redirect()->route('zones.index')
            ->with('success', 'Lugar turístico eliminado correctamente.');
    }
}
