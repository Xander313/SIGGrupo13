@extends('layouts.appAdmin')
@section('content')

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
                <div id="map-container" style="position: relative;">
                    <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #ddd;"></div>
                    <div id="mapa-error" style="display: none; position: absolute; top: 0; left: 0; right: 0; background: rgba(255,255,255,0.9); padding: 20px; text-align: center; color: red;">
                        <h4>Error al cargar el mapa</h4>
                        <p id="error-message"></p>
                        <button onclick="reintentarCarga()" class="btn btn-primary">Reintentar</button>
                    </div>
                    <div id="mapa-cargando" style="position: absolute; top: 0; left: 0; right: 0; background: rgba(255,255,255,0.9); padding: 20px; text-align: center;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando mapa...</span>
                        </div>
                        <p>Cargando mapa...</p>
                    </div>
                </div>
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
    // Variables globales
    var mapa;
    var marcador;
    var circulo;
    var intentosCarga = 0;
    var maxIntentos = 3;

    // Mostrar estado de carga
    function mostrarCargando(mostrar) {
        document.getElementById('mapa-cargando').style.display = mostrar ? 'block' : 'none';
    }

    // Mostrar error
    function mostrarError(mensaje) {
        document.getElementById('mapa-error').style.display = 'block';
        document.getElementById('error-message').textContent = mensaje;
    }

    // Ocultar error
    function ocultarError() {
        document.getElementById('mapa-error').style.display = 'none';
    }

    // Reintentar carga
    function reintentarCarga() {
        ocultarError();
        cargarMapa();
    }

    // Inicializar el mapa
    function initMap() {
        try {
            mostrarCargando(true);
            
            // Validar y parsear datos
            var latitud = parseFloat("{{ $punto->latitud }}".replace(',', '.'));
            var longitud = parseFloat("{{ $punto->longitud }}".replace(',', '.'));
            var radio = parseFloat("{{ $punto->radio }}".replace(',', '.'));
            
            if (isNaN(latitud) || isNaN(longitud) || isNaN(radio)) {
                throw new Error("Coordenadas o radio inválidos");
            }

            var ubicacion = { lat: latitud, lng: longitud };
            
            // Crear mapa
            mapa = new google.maps.Map(document.getElementById('mapa'), {
                center: ubicacion,
                zoom: 15,
                gestureHandling: "cooperative",
                mapTypeControl: true,
                streetViewControl: false
            });

            // Agregar marcador
            marcador = new google.maps.Marker({
                position: ubicacion,
                map: mapa,
                title: "{{ $punto->nombre }}"
            });

            // Agregar círculo de radio
            circulo = new google.maps.Circle({
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                map: mapa,
                center: ubicacion,
                radius: radio
            });

            // Ajustar vista para mostrar todo el círculo
            mapa.fitBounds(circulo.getBounds());
            
            mostrarCargando(false);
            ocultarError();
            
        } catch (error) {
            console.error("Error en initMap:", error);
            mostrarCargando(false);
            mostrarError("Error al cargar el mapa: " + error.message);
            
            if (intentosCarga < maxIntentos) {
                intentosCarga++;
                setTimeout(cargarMapa, 2000);
            }
        }
    }

    // Cargar API de Google Maps
    function cargarMapa() {
        try {
            mostrarCargando(true);
            
            if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
                initMap();
                return;
            }

            // Eliminar script anterior si existe
            var oldScript = document.getElementById('google-maps-script');
            if (oldScript) {
                oldScript.remove();
            }

            // Crear nuevo script
            var script = document.createElement('script');
            script.id = 'google-maps-script';
            script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyDV-hhnGIiWpn19hxGsr3NpUv7yFXaqFCU&callback=initMap`;
            script.async = true;
            script.defer = true;
            script.onerror = function() {
                mostrarCargando(false);
                mostrarError("Error al cargar la API de Google Maps");
                
                if (intentosCarga < maxIntentos) {
                    intentosCarga++;
                    setTimeout(cargarMapa, 2000);
                }
            };
            
            document.head.appendChild(script);
            
        } catch (error) {
            console.error("Error en cargarMapa:", error);
            mostrarCargando(false);
            mostrarError("Error al cargar el mapa");
            
            if (intentosCarga < maxIntentos) {
                intentosCarga++;
                setTimeout(cargarMapa, 2000);
            }
        }
    }

    // Iniciar carga cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        // Pequeño retraso para asegurar que el contenedor esté listo
        setTimeout(cargarMapa, 300);
    });
</script>

@endsection