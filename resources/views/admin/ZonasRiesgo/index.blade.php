@extends('layouts.appAdmin')

@section('content')

<br>
<h1 class="text-center">Listado de Zonas de Riesgo</h1>
<div class="container mt-4">
    <div class="mx-auto" style="max-width: 1000px;">
        <div class="text-right">
            <a href="{{ route('ZonasRiesgo.create') }}" class="btn btn-primary">
                Agregar nueva Zona de Riesgo
            </a>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Nivel de riesgo</th>
                        <th>Coordenada N°1</th>
                        <th>Coordenada N°2</th>
                        <th>Coordenada N°3</th>
                        <th>Coordenada N°4</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riesgos as $riesgoTemporal)
                    <tr>
                        <td>{{ $riesgoTemporal->nombre }}</td>
                        <td>{{ $riesgoTemporal->descripcion }}</td>
                        <td>{{ $riesgoTemporal->nivel }}</td>
                        <td>Latitud: {{ $riesgoTemporal->latitud1 }}<br>Longitud: {{ $riesgoTemporal->longitud1 }}</td>
                        <td>Latitud: {{ $riesgoTemporal->latitud2 }}<br>Longitud: {{ $riesgoTemporal->longitud2 }}</td>
                        <td>Latitud: {{ $riesgoTemporal->latitud3 }}<br>Longitud: {{ $riesgoTemporal->longitud3 }}</td>
                        <td>Latitud: {{ $riesgoTemporal->latitud4 }}<br>Longitud: {{ $riesgoTemporal->longitud4 }}</td>
                        <td class="text-center">
                            <a href="{{ route('ZonasRiesgo.edit', $riesgoTemporal->id) }}" class="btn btn-sm btn-primary me-1">Editar</a>

                            <form action="{{ route('ZonasRiesgo.destroy', $riesgoTemporal->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta Zona de riesgo?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay zonas de riesgo registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection