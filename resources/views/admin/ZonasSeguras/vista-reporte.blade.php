
<div class="container">
    <h2 class="mb-4">Vista previa del Reporte</h2>

    <div id="mapa" style="height: 500px; width: 100%; border: 1px solid #ccc;"></div>

    <form method="POST" action="{{ route('zonas-seguras.reporte') }}">
        @csrf
        <button type="submit" class="btn btn-danger mt-4">
            <i class="fas fa-file-pdf"></i> Generar PDF del Reporte
        </button>
    </form>
</div>

<!-- Leaflet core -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const zonas = @json($zonas);
    const map = L.map('mapa').setView([-0.937, -78.616], 7);

    // Mapa base (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    zonas.forEach(zona => {
        const lat = parseFloat(zona.latitud);
        const lng = parseFloat(zona.longitud);
        const radio = parseFloat(zona.radio);

        L.marker([lat, lng])
            .addTo(map)
            .bindPopup(zona.nombre);

        L.circle([lat, lng], {
            radius: radio,
            color: '#007bff',
            fillColor: '#007bff',
            fillOpacity: 0.2
        }).addTo(map);
    });
</script>
