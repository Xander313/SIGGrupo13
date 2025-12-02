@extends('layouts.appAdmin')

@section('content')

<br>
<h1 class="text-center">Listado de Lugares Turísticos</h1>

<div class="container mt-5">
    <div class="mx-auto" style="max-width: 100000px;">

        <a href="{{ route('zones.create') }}" class="btn btn-success mb-4">
            <i class="fas fa-plus-circle"></i> Registrar nuevo Lugar Turístico
        </a>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="zones-table">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Provincia</th>
                        <th>Tipo de Atracción</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Año</th>
                        <th>Accesibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($zones as $zone)
                    <tr>
                        <td>{{ $zone->NombreLugar }}</td>
                        <td>{{ $zone->province->NombreProvincia ?? '---' }}</td>
                        <td>{{ $zone->type->NombreTipoAtraccion ?? '---' }}</td>
                        <td>{{ $zone->Latitud }}</td>
                        <td>{{ $zone->Longitud }}</td>
                        <td>{{ $zone->AnioCreacion }}</td>
                        <td>{{ $zone->Accesibilidad }}</td>

                        <td class="text-center">

                            <a href="{{ route('zones.edit', $zone->IdLugarTuristico) }}" 
                               class="btn btn-sm btn-primary mb-2 d-block">
                                Editar
                            </a>

                            <form action="{{ route('zones.destroy', $zone->IdLugarTuristico) }}" 
                                  method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger btn-eliminar d-block">
                                    Eliminar
                                </button>
                            </form>

                            <button class="btn btn-info btn-sm mt-2 d-block" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalZone{{ $zone->IdLugarTuristico }}">
                                <i class="fas fa-map-marker-alt"></i> Ver Ubicación
                            </button>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay lugares turísticos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MODALES DE GOOGLE MAPS --}}
        @foreach ($zones as $zone)
        <div class="modal fade" id="modalZone{{ $zone->IdLugarTuristico }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-success">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">{{ $zone->NombreLugar }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div id="mapaZone{{ $zone->IdLugarTuristico }}" 
                             style="height: 400px; width: 100%; border: 2px solid green;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


{{-- CONFIRMACIÓN SWEET ALERT --}}
<script>
$(document).ready(function() {
    $('.btn-eliminar').on('click', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: '¿Eliminar este lugar turístico?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

{{-- INICIALIZAR MAPAS --}}
<script>
function initZonesMap() {
    @foreach($zones as $zone)
        const coords{{ $zone->IdLugarTuristico }} = {
            lat: {{ $zone->Latitud }},
            lng: {{ $zone->Longitud }}
        };

        const map{{ $zone->IdLugarTuristico }} = new google.maps.Map(
            document.getElementById("mapaZone{{ $zone->IdLugarTuristico }}"),
            {
                zoom: 15,
                center: coords{{ $zone->IdLugarTuristico }},
                mapTypeId: google.maps.MapTypeId.HYBRID,
            }
        );

        new google.maps.Marker({
            position: coords{{ $zone->IdLugarTuristico }},
            map: map{{ $zone->IdLugarTuristico }},
            title: "{{ $zone->NombreLugar }}"
        });
    @endforeach
}

function initMap() {
    initZonesMap();
}
</script>

{{-- DATATABLE --}}
<script>
$(document).ready(function() {
    new DataTable('#zones-table', {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
        },
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>

@endsection