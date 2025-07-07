<!-- 1. jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- 2. jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/localization/messages_es.min.js"></script>

<!-- 3. Bootstrap CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- 4. Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<!-- 5. DataTables core -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json"></script>

<!-- 6. DataTables Buttons (exportación e impresión) -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>

<!-- 7. Bootstrap FileInput -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.4/css/fileinput.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.4/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.4/js/locales/es.min.js"></script>

<!-- 8. SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe-d3jhyJysjrOpa1iPvNlJDL6QHQMPfg&libraries=places&callback=initMap"></script>








<div class="container mt-5">
    <h2>Zonas Seguras Registradas</h2>
    <a href="{{ route('zonas-seguras.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Nueva Zona Segura
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
                    <td>{{ $zona->latitud }} - {{ $zona->longitud }}</td>
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

