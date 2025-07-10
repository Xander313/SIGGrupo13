@extends('layouts.appUser')
@section('content')

<div class="container">
    <h2 class="mb-4">Vista previa del Reporte de Zonas de Riesgo</h2>

    <label for="filtroNivel" style="color: #000; font-weight: bold;">Filtrar por nivel de riesgo:</label>
    <select id="filtroNivel" class="form-select mb-3" style="max-width: 300px;">
        <option value="Todos">Todos</option>
        <option value="Alto">Alto</option>
        <option value="Medio">Medio</option>
        <option value="Bajo">Bajo</option>
    </select>


    <div id="mapa" style="height: 500px; width: 100%; border: 1px solid #ccc;"></div>

    <form method="POST" action="{{ route('usuarios-zonas-riesgo.reporte') }}">
        @csrf
        <input type="hidden" name="imagenMapa" id="imagenMapa">
            <input type="hidden" name="nivelSeleccionado" id="nivelSeleccionado">

        <button type="button" id="btnGenerarPDF" class="btn btn-danger mt-4">
            <i class="fas fa-file-pdf"></i> Generar reporte en PDF
        </button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<script>
let map;
let poligonos = [];
let marcadores = [];

function initMap() {
    map = new google.maps.Map(document.getElementById('mapa'), {
        center: { lat: -0.937, lng: -78.616 },
        zoom: 10
    });

    const riesgos = @json($riesgos);

    function renderRiesgos(filtro) {
        // Limpiar los polígonos y marcadores anteriores
        poligonos.forEach(p => p.setMap(null));
        marcadores.forEach(m => m.setMap(null));
        poligonos = [];
        marcadores = [];

        riesgos.forEach(riesgo => {
            if (filtro === 'Todos' || riesgo.nivel === filtro) {
                const coordenadas = [
                    { lat: parseFloat(riesgo.latitud1), lng: parseFloat(riesgo.longitud1) },
                    { lat: parseFloat(riesgo.latitud2), lng: parseFloat(riesgo.longitud2) },
                    { lat: parseFloat(riesgo.latitud3), lng: parseFloat(riesgo.longitud3) },
                    { lat: parseFloat(riesgo.latitud4), lng: parseFloat(riesgo.longitud4) }
                ];

                const color = riesgo.nivel === 'Alto' ? '#dc3545' :
                              riesgo.nivel === 'Medio' ? '#fd7e14' :
                              riesgo.nivel === 'Bajo' ? '#ffc107' : '#6c757d';

                const poligono = new google.maps.Polygon({
                    paths: coordenadas,
                    strokeColor: color,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.3
                });

                poligono.setMap(map);
                poligonos.push(poligono);

                const marker = new google.maps.Marker({
                    position: coordenadas[0],
                    map,
                    title: riesgo.nombre
                });

                marcadores.push(marker);
            }
        });
    }

    // Render inicial
    renderRiesgos('Todos');

    // Cambio dinámico sin recargar el mapa
    document.getElementById('filtroNivel').addEventListener('change', function () {
        const nivel = this.value;
        renderRiesgos(nivel);
    });

    // PDF + nivel actual
    document.getElementById('btnGenerarPDF').addEventListener('click', function () {
        const nivel = document.getElementById('filtroNivel').value;
        document.getElementById('nivelSeleccionado').value = nivel;

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
