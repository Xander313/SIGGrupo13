
@extends('layouts.appAdmin')
@section('content')

<div class="container mt-5">
    <h2>Zonas Seguras Registradas</h2>
    <a href="{{ route('zonas-seguras.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Nueva Zona Segura
    </a>
    <a href="{{ route('zonas-seguras.vista-reporte') }}" class="btn btn-primary mb-3">
        <i class="fas fa-map"></i> Vista previa del reporte
    </a>


    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981'
            });
        </script>
    @endif

    <table id="zonas-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Radio (m)</th>
                <th>Coordenadas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($zonas as $zona)
                <tr>
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->nombre }}</td>
                    <td>{{ $zona->tipo_seguridad }}</td>
                    <td>{{ $zona->radio }}</td>
                    <td>{{ $zona->latitud }} {{ $zona->longitud }}</td>
                    <td>
                        <a href="{{ route('zonas-seguras.edit', $zona->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalZona{{ $zona->id }}">
                            <i class="fas fa-map-marker-alt"></i> Ver Zona
                        </button>

                        <form action="{{ route('zonas-seguras.destroy', $zona->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta zona?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@foreach ($zonas as $zona)
<!-- Modal para la zona -->
<div class="modal fade" id="modalZona{{ $zona->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">
            Zona: {{ $zona->nombre }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="mapaZona{{ $zona->id }}" style="height: 400px; width: 100%; border:2px solid green;"></div>
      </div>
    </div>
  </div>
</div>
@endforeach


<script>
    function initZonas() {
        @foreach($zonas as $zona)

        const map{{ $zona->id }} = new google.maps.Map(document.getElementById('mapaZona{{ $zona->id }}'), {
            center: { lat: {{ $zona->latitud }}, lng: {{ $zona->longitud }} },
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        new google.maps.Marker({
            position: { lat: {{ $zona->latitud }}, lng: {{ $zona->longitud }} },


            map: map{{ $zona->id }},
            title: "Zona: {{ $zona->nombre }}"
        });
        new google.maps.Circle({
            strokeColor: "#10b981",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#34d399",
            fillOpacity: 0.4,
            map: map{{ $zona->id }},
            center: { lat: {{ $zona->latitud }}, lng: {{ $zona->longitud }} },
            radius: {{ $zona->radio }}
        });
        @endforeach
    }

    function initMap() {
        initZonas();
    }

</script>

<script>
$(document).ready(function() {
    let table = new DataTable('#zonas-table', {
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
