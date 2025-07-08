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
        <input type="number" name="radio" class="form-control" value="{{ $punto->radio }}" required min="1">
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
    <button type="button" onclick="graficarCirculo()" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalGraficoCirculo">
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
    var mapa;
    var marcador;

    function initMap() {
        var ubicacionActual = { lat: {{ $punto->latitud }}, lng: {{ $punto->longitud }} };
        
        mapa = new google.maps.Map(document.getElementById('mapa'), {
            center: ubicacionActual,
            zoom: 15
        });

        marcador = new google.maps.Marker({
            position: ubicacionActual,
            map: mapa,
            draggable: true,
            title: "Arrastra para cambiar ubicación"
        });

        marcador.addListener('dragend', function() {
            var posicion = marcador.getPosition();
            document.getElementById('latitud').value = posicion.lat();
            document.getElementById('longitud').value = posicion.lng();
        });
    }

    function graficarCirculo() {
        var radio = document.querySelector('input[name="radio"]').value;
        var latitud = document.getElementById('latitud').value;
        var longitud = document.getElementById('longitud').value;

        var centro = new google.maps.LatLng(parseFloat(latitud), parseFloat(longitud));
        
        var mapaCirculo = new google.maps.Map(document.getElementById('mapa-circulo'), {
            center: centro,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        });

        new google.maps.Marker({
            position: centro,
            map: mapaCirculo,
            title: "Centro del Punto"
        });

        new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
            map: mapaCirculo,
            center: centro,
            radius: parseFloat(radio)
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV-hhnGIiWpn19hxGsr3NpUv7yFXaqFCU&callback=initMap"></script>

@endsection
