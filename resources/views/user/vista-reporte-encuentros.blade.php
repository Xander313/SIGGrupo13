@extends('layouts.appAdmin')
@section('content')

<div class="container">
    <h2 style="color: #000" class="mb-4">Reporte de Puntos de Encuentro</h2>

    <div id="mapa" style="height: 500px; width: 100%; border: 1px solid #ccc;"></div>

    <form method="POST" action="{{ route('admin.puntos-encuentro.generar-reporte') }}">
        @csrf
        <input type="hidden" name="imagenMapa" id="imagenMapa">

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

    const puntos = @json($puntos);

    // Renderizar todos los puntos
    puntos.forEach(p => {
        // Crear contenido del tooltip
        const contentString = `
            <div style="padding: 10px; min-width: 200px;">
                <h5 style="margin-bottom: 10px; color: #0d6efd;">${p.nombre}</h5>
                <div style="margin-bottom: 5px;">
                    <strong>Capacidad:</strong> ${p.capacidad} personas
                </div>
                <div style="margin-bottom: 5px;">
                    <strong>Responsable:</strong> ${p.responsable}
                </div>
                
                <div>
                    <strong>Ubicación:</strong><br>
                    Lat: ${p.latitud}<br>
                    Lng: ${p.longitud}
                </div>
            </div>
        `;

        // Crear ventana de información
        const infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        const marker = new google.maps.Marker({
            position: { lat: parseFloat(p.latitud), lng: parseFloat(p.longitud) },
            map,
            title: p.nombre,
            icon: window.mapaIconos.obtenerAleatorio()
        });

        // Mostrar tooltip al pasar el cursor
        marker.addListener('mouseover', () => {
            infowindow.open({
                anchor: marker,
                map,
                shouldFocus: false
            });
        });

        // Ocultar tooltip al quitar el cursor
        marker.addListener('mouseout', () => {
            infowindow.close();
        });

        const circle = new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
            map,
            center: marker.getPosition(),
            radius: parseFloat(p.radio)
        });

        marcadores.push(marker);
        circulos.push(circle);
    });

    // Ajustar el zoom para mostrar todos los puntos
    if (puntos.length > 0) {
        const bounds = new google.maps.LatLngBounds();
        puntos.forEach(p => {
            bounds.extend(new google.maps.LatLng(parseFloat(p.latitud), parseFloat(p.longitud)));
        });
        map.fitBounds(bounds);
    }

    // Captura del mapa para PDF
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