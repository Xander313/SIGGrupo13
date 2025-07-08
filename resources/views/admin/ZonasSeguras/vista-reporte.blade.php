
<div class="container">
    <h2 class="mb-4">Vista previa del Reporte</h2>

    <div id="mapa" style="height: 500px; width: 100%; border: 1px solid #ccc;"></div>

    <form method="POST" action="{{ route('zonas-seguras.reporte') }}">
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

    const zonas = @json($zonas);

    zonas.forEach(z => {
        const marker = new google.maps.Marker({
            position: { lat: parseFloat(z.latitud), lng: parseFloat(z.longitud) },
            map,
            title: z.nombre
        });

        new google.maps.Circle({
            strokeColor: '#007bff',
            strokeOpacity: 1,
            strokeWeight: 1,
            fillColor: '#007bff',
            fillOpacity: 0.2,
            map,
            center: marker.getPosition(),
            radius: parseFloat(z.radio)
        });
    });

    // ✅ Captura el mapa después de renderizar
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
