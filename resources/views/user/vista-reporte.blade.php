

@extends('layouts.appUser')
@section('content')

<div class="container">
    <h2 style= "color: #fff" class="mb-4">Reporte de zonas seguras</h2>

    <label for="filtroZona" style="color: #fff; font-weight: bold;">Filtrar por tipo de zona segura:</label>
    <select id="filtroZona" class="form-select mb-3" style="max-width: 300px;">
        <option value="Todos">Todos</option>
        <option value="Refugio">Refugio</option>
        <option value="Centro de salud">Centro de salud</option>
        <option value="Zona de evacuación">Zona de evacuación</option>
    </select>


    <div id="mapa" style="height: 500px; width: 100%; border: 1px solid #ccc;"></div>

    <form method="POST" action="{{ route('usuarios-zonas-seguras.reporte') }}">
        @csrf
        <input type="hidden" name="imagenMapa" id="imagenMapa">
        <input type="hidden" name="tipoSeleccionado" id="tipoSeleccionado">

        <button type="button" id="btnGenerarPDF" class="btn btn-danger mt-4">
            <i class="fas fa-file-pdf"></i> Generar reporte en PDF
        </button>

    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>




<script>
let map;
let circulos = [];
let marcadores = [];

function initMap() {
    map = new google.maps.Map(document.getElementById('mapa'), {
        center: { lat: -0.937, lng: -78.616 },
        zoom: 8
    });

    const zonas = @json($zonas);

    function renderZonas(filtro) {
        // Limpiar círculos y marcadores anteriores
        circulos.forEach(c => c.setMap(null));
        marcadores.forEach(m => m.setMap(null));
        circulos = [];
        marcadores = [];

        zonas.forEach(z => {
            if (filtro === 'Todos' || z.tipo_seguridad === filtro) {
                const color = z.tipo_seguridad === 'Refugio' ? '#28a745' :
                              z.tipo_seguridad === 'Centro de salud' ? '#17a2b8' :
                              z.tipo_seguridad === 'Zona de evacuación' ? '#dc3545' : '#007bff';

                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(z.latitud), lng: parseFloat(z.longitud) },
                    map,
                    title: z.nombre
                });

                const circle = new google.maps.Circle({
                    strokeColor: color,
                    strokeOpacity: 1,
                    strokeWeight: 1,
                    fillColor: color,
                    fillOpacity: 0.2,
                    map,
                    center: marker.getPosition(),
                    radius: parseFloat(z.radio)
                });

                marcadores.push(marker);
                circulos.push(circle);
            }
        });
    }

    // Render inicial
    renderZonas('Todos');

    // Cambiar filtro dinámicamente
    document.getElementById('filtroZona').addEventListener('change', function () {
        const valorSeleccionado = this.value;
        renderZonas(valorSeleccionado);
    });

    // Captura del mapa
    document.getElementById('btnGenerarPDF').addEventListener('click', function () {
        html2canvas(document.getElementById('mapa')).then(canvas => {
            const imagenBase64 = canvas.toDataURL('image/png');
            document.getElementById('imagenMapa').value = imagenBase64;
            this.closest('form').submit();
        }).catch(error => {
            console.error('Error al capturar el mapa:', error);
            alert('No se pudo capturar el mapa.');
        });
    });

    document.getElementById('btnGenerarPDF').addEventListener('click', function () {
        const filtro = document.getElementById('filtroZona').value;
        document.getElementById('tipoSeleccionado').value = filtro;

        html2canvas(document.getElementById('mapa')).then(canvas => {
            const imagenBase64 = canvas.toDataURL('image/png');
            document.getElementById('imagenMapa').value = imagenBase64;
            this.closest('form').submit();
        }).catch(error => {
            console.error('Error al capturar el mapa:', error);
            alert('No se pudo capturar el mapa.');
        });
    });

}
</script>


@endsection