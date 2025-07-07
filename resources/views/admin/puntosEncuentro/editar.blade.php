@extends('layout.app')

@section('contenido')
<h1>EDITAR PUNTO DE ENCUENTRO</h1>
<form action="{{ route('puntos-encuentro.update', $punto->id) }}" method="POST">
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
    <a href="{{ route('puntos-encuentro.index') }}" class="btn btn-danger">Cancelar</a>
</form>

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
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap"></script>
@endsection