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
        <input type="number" name="radio" class="form-control" value="50" placeholder="Radio en metros" required min="1">
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
    </div>
    <div id="mapa" style="margin-top:50px; height: 500px; width: 80%; border: 2px solid #ddd; margin-top: 10px; margin: auto;"></div>


    <button type="submit" class="btn btn-success">Guardar</button>

    <a href="{{ route('admin.puntos-encuentro.index') }}" class="btn btn-danger">Cancelar</a>
</form>



<script>
function initMap() {
    const ubicacionInicial = { lat: -0.9374805, lng: -78.6161327 };

    const mapa = new google.maps.Map(document.getElementById('mapa'), {
        center: ubicacionInicial,
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    const marcador = new google.maps.Marker({
        position: ubicacionInicial,
        map: mapa,
        draggable: true,
        title: "Arrastra para seleccionar ubicación"
    });

    const radioInput = document.querySelector('input[name="radio"]');
    const circulo = new google.maps.Circle({
        strokeColor: "#000b8f",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#000b8f",
        fillOpacity: 0.35,
        map: mapa,
        center: ubicacionInicial,
        radius: parseFloat(radioInput.value || 100)
    });

    // Actualizar coordenadas y círculo al mover el marcador
    marcador.addListener('drag', function () {
        const pos = marcador.getPosition();
        document.getElementById('latitud').value = pos.lat().toFixed(7);
        document.getElementById('longitud').value = pos.lng().toFixed(7);
        circulo.setCenter(pos);
    });

    // Actualizar radio del círculo al escribir
    radioInput.addEventListener('input', function () {
        const nuevoRadio = parseFloat(this.value);
        circulo.setRadius(nuevoRadio);
    });

    // Reactivar círculo si se modifican manualmente las coordenadas
    ['latitud', 'longitud'].forEach(id => {
        document.getElementById(id).addEventListener('change', function () {
            const lat = parseFloat(document.getElementById('latitud').value);
            const lng = parseFloat(document.getElementById('longitud').value);
            if (!isNaN(lat) && !isNaN(lng)) {
                const nuevaPos = new google.maps.LatLng(lat, lng);
                marcador.setPosition(nuevaPos);
                circulo.setCenter(nuevaPos);
                mapa.setCenter(nuevaPos);
            }
        });
    });
}

</script>

@endsection
