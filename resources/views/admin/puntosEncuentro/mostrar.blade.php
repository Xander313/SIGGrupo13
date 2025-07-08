<div class="container">
    <h1 class="mb-4">Detalles del Punto de Encuentro</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Información Básica</h5>
                    <p><strong>Nombre:</strong> {{ $punto->nombre }}</p>
                    <p><strong>Capacidad:</strong> {{ $punto->capacidad }} personas</p>
                    <p><strong>Responsable:</strong> {{ $punto->responsable }}</p>
                    <p><strong>Radio de Cobertura:</strong> {{ $punto->radio }} metros</p>
                </div>
                <div class="col-md-6">
                    <h5>Ubicación</h5>
                    <p><strong>Latitud:</strong> {{ $punto->latitud }}</p>
                    <p><strong>Longitud:</strong> {{ $punto->longitud }}</p>
                </div>
            </div>
            
            <div class="mt-4">
                <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #ddd;"></div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.puntos-encuentro.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<script>
    function initMap() {
        var ubicacion = { lat: {{ $punto->latitud }}, lng: {{ $punto->longitud }} };
        var radio = {{ $punto->radio }};
        
        var mapa = new google.maps.Map(document.getElementById('mapa'), {
            center: ubicacion,
            zoom: 15
        });

        new google.maps.Marker({
            position: ubicacion,
            map: mapa,
            title: "{{ $punto->nombre }}"
        });

        new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
            map: mapa,
            center: ubicacion,
            radius: radio
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV-hhnGIiWpn19hxGsr3NpUv7yFXaqFCU&callback=initMap"></script>