@extends('layouts.appAdmin')
@section('content')

<h1>NUEVO PUNTO DE ENCUENTRO</h1>
<form action="{{ route('admin.puntos-encuentro.store') }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label class="form-label"><b>Nombre:</b></label>
        <input type="text" name="nombre" class="form-control" placeholder="Nombre del punto" required>
    </div>

    <div class="mb-3">
        <label class="form-label"><b>Capacidad:</b></label>
        <input type="number" name="capacidad" class="form-control" placeholder="Capacidad de personas" required min="1">
    </div>

    <div class="mb-3">
        <label class="form-label"><b>Responsable:</b></label>
        <input type="text" name="responsable" class="form-control" placeholder="Nombre del responsable" required>
    </div>

    <div class="mb-3">
        <label class="form-label"><b>Radio de Cobertura (metros):</b></label>
        <input type="number" name="radio" class="form-control" value="50" placeholder="Radio en metros" required min="1" id="radio-input">
    </div>

    <div class="mb-3">
        <label class="form-label"><b>Ubicación:</b></label>
        <div class="row">
            <div class="col-md-6">
                <label>Latitud:</label>
                <input type="number" step="any" id="latitud" value="-0.9374805" name="latitud" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Longitud:</label>
                <input type="number" step="any" id="longitud" value="-78.6161327" name="longitud" class="form-control" readonly>
            </div>
        </div>
        <div id="mapa" style="height: 500px; width: 100%; border: 2px solid #ddd; margin-top: 10px;"></div>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('admin.puntos-encuentro.index') }}" class="btn btn-danger">Cancelar</a>
</form>

<script>
function initMap() {
    const ubicacionInicial = { lat: -0.9374805, lng: -78.6161327 };
    const mapa = new google.maps.Map(document.getElementById('mapa'), {
        center: ubicacionInicial,
        zoom: 15
    });

    // Marcador con icono aleatorio
    const marcador = new google.maps.Marker({
        position: ubicacionInicial,
        map: mapa,
        draggable: true,
        title: "Arrastra para seleccionar ubicación",
        icon: window.mapaIconos.obtenerAleatorio()
    });

    // Círculo de cobertura
    const radioInput = document.getElementById('radio-input');
    let radio = parseFloat(radioInput.value) || 50;
    const circulo = new google.maps.Circle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
        map: mapa,
        center: ubicacionInicial,
        radius: radio
    });

    // Actualizar coordenadas y círculo al mover el marcador
    marcador.addListener('drag', function() {
        const nuevaPosicion = marcador.getPosition();
        document.getElementById('latitud').value = nuevaPosicion.lat().toFixed(7);
        document.getElementById('longitud').value = nuevaPosicion.lng().toFixed(7);
        circulo.setCenter(nuevaPosicion);
    });

    // Actualizar radio cuando cambie el input
    radioInput.addEventListener('input', function() {
        radio = parseFloat(this.value) || 50;
        circulo.setRadius(radio);
    });
}
</script>

@endsection