@extends('layouts.appAdmin')
@section('content')

<div class="container">
    <h2 class="mb-4">Vista previa del Reporte de Zonas de Riesgo</h2>

    <div id="mapa" style="height: 500px; width: 100%; border: 1px solid #ccc;"></div>

    <form method="POST" action="{{ route('zonas-riesgo.reporte') }}">
        @csrf
        <input type="hidden" name="imagenMapa" id="imagenMapa">

        <button type="button" id="btnGenerarPDF" class="btn btn-danger mt-4">
            <i class="fas fa-file-pdf"></i> Generar reporte en PDF
        </button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
function initMap() {
    const map = new google.maps.Map(document.getElementById('mapa'), {
        center: { lat: -0.937, lng: -78.616 },
        zoom: 7
    });

    const riesgos = @json($riesgos); // asegúrate de pasar $riesgos desde el controlador

    riesgos.forEach(riesgo => {
        const coordenadas = [
            { lat: parseFloat(riesgo.latitud1), lng: parseFloat(riesgo.longitud1) },
            { lat: parseFloat(riesgo.latitud2), lng: parseFloat(riesgo.longitud2) },
            { lat: parseFloat(riesgo.latitud3), lng: parseFloat(riesgo.longitud3) },
            { lat: parseFloat(riesgo.latitud4), lng: parseFloat(riesgo.longitud4) }
        ];

        const poligono = new google.maps.Polygon({
            paths: coordenadas,
            strokeColor: '#dc3545',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#dc3545',
            fillOpacity: 0.3
        });

        poligono.setMap(map);

        // Opcional: marcador en la primera coordenada
        new google.maps.Marker({
            position: coordenadas[0],
            map,
            title: riesgo.nombre
        });
    });

    // Captura el mapa y genera PDF
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
}
</script>

@endsection
