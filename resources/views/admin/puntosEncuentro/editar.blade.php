@extends('layouts.appAdmin')
@section('content')

<h1>EDITAR PUNTO DE ENCUENTRO</h1>
<form action="{{ route('admin.puntos-encuentro.update', $punto->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label class="form-label"><b>Nombre:</b></label>
        <input type="text" name="nombre" class="form-control" value="{{ $punto->nombre }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label"><b>Capacidad:</b></label>
        <input type="number" name="capacidad" class="form-control" value="{{ $punto->capacidad }}" required min="1">
    </div>

    <div class="mb-3">
        <label class="form-label"><b>Responsable:</b></label>
        <input type="text" name="responsable" class="form-control" value="{{ $punto->responsable }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label"><b>Radio de Cobertura (metros):</b></label>
        <input type="number" name="radio" class="form-control" value="{{ $punto->radio }}" required min="1" id="radio-input">
    </div>

    <div class="mb-3">
        <label class="form-label"><b>Ubicación:</b></label>
        <div class="row">
            <div class="col-md-6">
                <label>Latitud:</label>
                <input type="number" step="any" id="latitud" name="latitud" class="form-control" value="{{ $punto->latitud }}" readonly>
            </div>
            <div class="col-md-6">
                <label>Longitud:</label>
                <input type="number" step="any" id="longitud" name="longitud" class="form-control" value="{{ $punto->longitud }}" readonly>
            </div>
        </div>
        <div id="mapa" style="height: 300px; width: 100%; border: 2px solid #ddd; margin-top: 10px;"></div>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalGraficoCirculo" id="btn-ver-radio">
        Ver Radio
    </button>
    <a href="{{ route('admin.puntos-encuentro.index') }}" class="btn btn-danger">Cancelar</a>
</form>

<!-- Modal para visualizar el radio -->
<div class="modal fade" id="modalGraficoCirculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Radio de Cobertura del Punto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="mapa-circulo" style="height: 400px; width: 100%; border: 2px solid blue;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
// Variables globales
let mapa;
let marcador;
let circuloPrincipal;

// Inicializar el mapa principal
function initMap() {
    const ubicacionActual = {
        lat: parseFloat({{ $punto->latitud }}),
        lng: parseFloat({{ $punto->longitud }})
    };

    // Crear el mapa
    mapa = new google.maps.Map(document.getElementById('mapa'), {
        center: ubicacionActual,
        zoom: 15
    });

    // Marcador arrastrable con icono aleatorio
    marcador = new google.maps.Marker({
        position: ubicacionActual,
        map: mapa,
        draggable: true,
        title: "Arrastra para cambiar ubicación",
        icon: window.mapaIconos.obtenerAleatorio()
    });

    // Evento al arrastrar el marcador
    marcador.addListener('drag', function() {
        const posicion = marcador.getPosition();
        document.getElementById('latitud').value = posicion.lat().toFixed(7);
        document.getElementById('longitud').value = posicion.lng().toFixed(7);
        if (circuloPrincipal) {
            circuloPrincipal.setCenter(posicion);
        }
    });

    // Dibujar el círculo inicial
    dibujarCirculoPrincipal();

    // Evento dinámico para actualizar el radio
    document.getElementById('radio-input').addEventListener('input', function() {
        dibujarCirculoPrincipal();
    });

    // Configurar el mapa del modal
    configurarMapaModal();
}

// Dibuja o actualiza el círculo principal
function dibujarCirculoPrincipal() {
    const radio = parseFloat(document.getElementById('radio-input').value);
    const centro = marcador.getPosition();

    if (circuloPrincipal) {
        circuloPrincipal.setRadius(radio);
        circuloPrincipal.setCenter(centro);
    } else {
        circuloPrincipal = new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
            map: mapa,
            center: centro,
            radius: radio
        });
    }
}

// Configurar el mapa del modal
function configurarMapaModal() {
    $('#modalGraficoCirculo').on('shown.bs.modal', function() {
        const ubicacionActual = marcador.getPosition();
        const radio = parseFloat(document.getElementById('radio-input').value);
        
        const mapaModal = new google.maps.Map(document.getElementById('mapa-circulo'), {
            center: ubicacionActual,
            zoom: 15
        });

        new google.maps.Marker({
            position: ubicacionActual,
            map: mapaModal,
            title: "{{ $punto->nombre }}",
            icon: window.mapaIconos.obtenerAleatorio()
        });

        new google.maps.Circle({
            strokeColor: "#0000FF",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#0000FF",
            fillOpacity: 0.35,
            map: mapaModal,
            center: ubicacionActual,
            radius: radio
        });
    });
}
</script>

<!-- Cargar la API de Google Maps -->
<script>
    function loadGoogleMaps() {
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDV-hhnGIiWpn19hxGsr3NpUv7yFXaqFCU&callback=initMap';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }
    
    // Cargar el mapa cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', loadGoogleMaps);
</script>

@endsection