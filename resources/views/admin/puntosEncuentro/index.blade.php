@extends('layouts.appAdmin')
@section('content')

<div class="container">
    <h1 class="text-center mb-4">Puntos de Encuentro</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.puntos-encuentro.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Punto
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Capacidad</th>
                    <th>Responsable</th>
                    <th>Radio de Cobertura</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($puntos as $punto)
                <tr>
                    <td>{{ $punto->nombre }}</td>
                    <td>{{ $punto->capacidad }} personas</td>
                    <td>{{ $punto->responsable }}</td>
                    <td>{{ $punto->radio }} metros</td>
                    <td>
                        <small>Lat: {{ $punto->latitud }}</small><br>
                        <small>Lng: {{ $punto->longitud }}</small>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.puntos-encuentro.show', $punto->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.puntos-encuentro.edit', $punto->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.puntos-encuentro.destroy', $punto->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este punto?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No hay puntos de encuentro registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
