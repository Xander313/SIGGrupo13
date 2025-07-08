
@extends('layouts.appAdmin')
@section('content')

<br><br><br><br><br>
<div class='row'>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('zonas-seguras.update', $zona) }}" method="POST">
            @csrf
            @method('PUT')
            <h3><b>Editar Zona Segura</b></h3>
            <hr>

            <label for="nombre"><b>Nombre de la zona:</b></label>
            <input type="text" name="nombre" id="nombre" value="{{ $zona->nombre }}" class="form-control" required>

            <label for="tipo_seguridad"><b>Tipo de seguridad:</b></label>
            <select name="tipo_seguridad" id="tipo_seguridad" class="form-select" required>
                <option value="">--- Seleccione ---</option>
                <option value="Refugio" {{ $zona->tipo_seguridad == 'Refugio' ? 'selected' : '' }}>Refugio</option>
                <option value="Zona de evacuación" {{ $zona->tipo_seguridad == 'Zona de evacuación' ? 'selected' : '' }}>Zona de evacuación</option>
                <option value="Centro de salud" {{ $zona->tipo_seguridad == 'Centro de salud' ? 'selected' : '' }}>Centro de salud</option>
            </select>

            <label for="radio"><b>Radio (en metros):</b></label>
            <input type="number" name="radio" id="radio" value="{{ $zona->radio }}" class="form-control" required>

            <label><b>Coordenadas centrales:</b></label>
            <input type="text" name="latitud" id="latitud" value="{{ $zona->latitud }}" class="form-control" readonly required>
            <input type="text" name="longitud" id="longitud" value="{{ $zona->longitud }}" class="form-control" readonly required>

            <div id="mapa2" style="height: 300px; width: 100%; border: 3px solid #2563eb; margin-top: 15px; border-radius: 6px;"></div>

            <br>
            <center>
                <a href="{{ route('zonas-seguras.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Actualizar Zona</button>
            </center>
        </form>
    </div>
</div>

<script>
function initMap() {
    const defaultCoords = {
        lat: parseFloat(document.getElementById('latitud').value),
        lng: parseFloat(document.getElementById('longitud').value)
    };

    const mapa = new google.maps.Map(document.getElementById('mapa2'), {
        center: defaultCoords,
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    const marker = new google.maps.Marker({
        position: defaultCoords,
        map: mapa,
        draggable: true,
        title: "Arrastra para mover la zona segura"
    });

    const circle = new google.maps.Circle({
        strokeColor: "#10b981",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#34d399",
        fillOpacity: 0.4,
        map: mapa,
        center: defaultCoords,
        radius: parseFloat(document.getElementById('radio').value || 100),
    });

    marker.addListener('drag', function () {
        const pos = marker.getPosition();
        document.getElementById('latitud').value = pos.lat().toFixed(7);
        document.getElementById('longitud').value = pos.lng().toFixed(7);
        circle.setCenter(pos);
    });

    document.getElementById('radio').addEventListener('input', function () {
        const nuevoRadio = parseFloat(this.value);
        circle.setRadius(nuevoRadio);
    });

    const actualizarDesdeInputs = () => {
        const lat = parseFloat(document.getElementById('latitud').value);
        const lng = parseFloat(document.getElementById('longitud').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            const nuevaPos = new google.maps.LatLng(lat, lng);
            marker.setPosition(nuevaPos);
            circle.setCenter(nuevaPos);
            mapa.setCenter(nuevaPos);
        }
    };

    document.getElementById('latitud').addEventListener('change', actualizarDesdeInputs);
    document.getElementById('longitud').addEventListener('change', actualizarDesdeInputs);
}
</script>

@endsection


