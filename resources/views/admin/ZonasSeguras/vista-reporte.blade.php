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


<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- leaflet-image para capturar el mapa como imagen -->
<script src="https://unpkg.com/leaflet-image@0.0.4/leaflet-image.js"></script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe-d3jhyJysjrOpa1iPvNlJDL6QHQMPfg&libraries=places&callback=initMap"></script>


<div class="container">
    <h2>Vista previa del Reporte</h2>

    <div id="mapa" style="height: 500px; width: 100%; border: 1px solid #ccc;"></div>

    <form id="formReporte" method="POST" action="{{ route('zonas-seguras.reporte') }}">
        @csrf
        <input type="hidden" name="imagenMapa" id="imagenMapa">
        <button type="button" class="btn btn-danger mt-4" onclick="capturarMapa()">
            <i class="fas fa-file-pdf"></i> Generar PDF del Reporte
        </button>
    </form>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    const zonas = @json($zonas);
    var map = L.map('mapa').setView([-0.937, -78.616], 7);

    // 🗺️ Capa base
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // 📍 Marcadores y 🟢 círculos
    zonas.forEach(zona => {
        const lat = parseFloat(zona.latitud);
        const lng = parseFloat(zona.longitud);
        const radio = parseFloat(zona.radio);

        L.marker([lat, lng]).addTo(map).bindPopup(zona.nombre);

        L.circle([lat, lng], {
            radius: radio,
            color: '#007bff',
            fillColor: '#007bff',
            fillOpacity: 0.2
        }).addTo(map);
    });

    // 📸 Capturar imagen con leaflet-image
    function capturarMapa() {
        leafletImage(map, function(err, canvas) {
            const imgData = canvas.toDataURL('image/png');
            document.getElementById('imagenMapa').value = imgData;
            document.getElementById('formReporte').submit();
        });
    }
</script>
