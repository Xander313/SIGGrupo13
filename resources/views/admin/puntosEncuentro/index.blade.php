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
        <a href="{{ route('admin.puntos-encuentro.vista-reporte') }}" class="btn btn-info">
            <i class="fas fa-map"></i> Vista previa del reporte
        </a>
    </div>

    <div class="table-responsive">
        <table id="puntos-table" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Capacidad</th>
                    <th>Responsable</th>
                    <th>Radio (m)</th>
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
                            <a href="{{ route('admin.puntos-encuentro.edit', $punto->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalPunto{{ $punto->id }}">
                                <i class="fas fa-map-marker-alt"></i> Ver
                            </button>
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

@foreach ($puntos as $punto)
<!-- Modal para ver el punto -->
<div class="modal fade" id="modalPunto{{ $punto->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Punto: {{ $punto->nombre }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="mapaPunto{{ $punto->id }}" style="height: 400px; width: 100%; border:2px solid #0d6efd;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endforeach

<script>
// Función para inicializar un mapa específico
function initMapaPunto(id, lat, lng, radio, nombre) {
    const mapaElement = document.getElementById('mapaPunto'+id);
    
    // Solo inicializar si el elemento existe y no se ha inicializado antes
    if (mapaElement && !mapaElement._mapInitialized) {
        const mapa = new google.maps.Map(mapaElement, {
            center: { lat: parseFloat(lat), lng: parseFloat(lng) },
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Marcador con icono aleatorio
        new google.maps.Marker({
            position: { lat: parseFloat(lat), lng: parseFloat(lng) },
            map: mapa,
            title: nombre,
            icon: window.mapaIconos.obtenerAleatorio()
        });

        // Círculo de cobertura
        new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
            map: mapa,
            center: { lat: parseFloat(lat), lng: parseFloat(lng) },
            radius: parseFloat(radio)
        });

        // Marcar como inicializado
        mapaElement._mapInitialized = true;
    }
}

// Escuchar cuando se muestre el modal
document.addEventListener('DOMContentLoaded', function() {
    @foreach($puntos as $punto)
    document.getElementById('modalPunto{{ $punto->id }}').addEventListener('shown.bs.modal', function () {
        initMapaPunto(
            '{{ $punto->id }}', 
            '{{ $punto->latitud }}', 
            '{{ $punto->longitud }}', 
            '{{ $punto->radio }}', 
            '{{ $punto->nombre }}'
        );
    });
    @endforeach
});
</script>

<script>
$(document).ready(function() {
    $('#puntos-table').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            'print'
        ]
    });
});
</script>

@endsection