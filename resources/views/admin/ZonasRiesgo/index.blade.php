@extends('layouts.appAdmin')

@section('content')

<br>
<h1 class="text-center">Listado de Zonas de Riesgo</h1>
<div class="container mt-5">
    <div class="mx-auto" style="max-width: 100000px;">
        
            <a href="{{ route('ZonasRiesgo.create') }}" class="btn btn-success mb-4">
                <i class="fas fa-plus-circle"></i>Agregar nueva Zona de Riesgo
            </a>
            <a href="{{ route('zonas-riesgo.vista-reporte') }}" class="btn btn-primary mb-4">
                <i class="fas fa-map"></i>Vista previa del reporte
            </a>
        
        <br>
        <div class="table-responsive" >
            <table class="table table-hover table-bordered align-middle" id="zonas-riesgo" >
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
                            <a href="{{ route('ZonasRiesgo.edit', $riesgoTemporal->id) }}" class="btn btn-sm btn-primary d-block mb-2">
                                Editar
                            </a>

                            <form action="{{ route('ZonasRiesgo.destroy', $riesgoTemporal->id) }}" method="POST" class="d-inline-block mb-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-eliminar d-block">
                                    Eliminar
                                </button>
                            </form>

                            <button class="btn btn-info btn-sm d-block mt-2" data-bs-toggle="modal" data-bs-target="#modalRiesgo{{ $riesgoTemporal->id }}">
                                <i class="fas fa-map-marked-alt"></i> Ver Polígono
                            </button>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay zonas de riesgo registradas.</td>
                    </tr>
                    @endforelse
                    @foreach ($riesgos as $riesgo)
                    <div class="modal fade" id="modalRiesgo{{ $riesgo->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content border-danger">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title">Zona de Riesgo: {{ $riesgo->nombre }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="mapaRiesgo{{ $riesgo->id }}" style="height: 400px; width: 100%; border: 2px solid red;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btn-eliminar').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    Swal.fire(
                        'Cancelado',
                        'La zona de riesgo no fue eliminada.',
                        'info'
                    );
                }
            });
        });
    });
</script>

<script>
    function initZonasRiesgo() {
        @foreach($riesgos as $riesgo)
            const coords{{ $riesgo->id }} = [
                { lat: {{ $riesgo->latitud1 }}, lng: {{ $riesgo->longitud1 }} },
                { lat: {{ $riesgo->latitud2 }}, lng: {{ $riesgo->longitud2 }} },
                { lat: {{ $riesgo->latitud3 }}, lng: {{ $riesgo->longitud3 }} },
                { lat: {{ $riesgo->latitud4 }}, lng: {{ $riesgo->longitud4 }} },
            ];

            const map{{ $riesgo->id }} = new google.maps.Map(document.getElementById("mapaRiesgo{{ $riesgo->id }}"), {
                zoom: 15,
                center: coords{{ $riesgo->id }}[0],
                mapTypeId: google.maps.MapTypeId.HYBRID,
            });

            let colorStroke{{ $riesgo->id }} = '';
            let colorFill{{ $riesgo->id }} = '';

            switch ("{{ $riesgo->nivel }}") {
                case 'Alto':
                    colorStroke{{ $riesgo->id }} = '#dc3545';  // Rojo
                    colorFill{{ $riesgo->id }} = '#f5c6cb';
                    break;
                case 'Medio':
                    colorStroke{{ $riesgo->id }} = '#fd7e14';  // Naranja
                    colorFill{{ $riesgo->id }} = '#ffe5b4';
                    break;
                case 'Bajo':
                    colorStroke{{ $riesgo->id }} = '#ffc107';  // Amarillo
                    colorFill{{ $riesgo->id }} = '#fff3cd';
                    break;
                default:
                    colorStroke{{ $riesgo->id }} = '#6c757d';  // Gris
                    colorFill{{ $riesgo->id }} = '#dee2e6';
                    break;
            }

            new google.maps.Polygon({
                paths: coords{{ $riesgo->id }},
                strokeColor: colorStroke{{ $riesgo->id }},
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: colorFill{{ $riesgo->id }},
                fillOpacity: 0.35,
                map: map{{ $riesgo->id }}
            });

        @endforeach
    }

    function initMap() {
        initZonasRiesgo();
    }
</script>
<script>
$(document).ready(function() {
    let table = new DataTable('#zonas-riesgo', {
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