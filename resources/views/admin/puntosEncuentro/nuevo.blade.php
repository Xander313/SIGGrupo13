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
        <label class="form-label"><b>Ubicación:</b></label>
        <div class="row">
            <div class="col-md-6">
                <label>Latitud:</label>
                <input type="number" step="any" id="latitud" name="latitud" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Longitud:</label>
                <input type="number" step="any" id="longitud" name="longitud" class="form-control" readonly>
            </div>
        </div>
        <div id="mapa" style="height: 300px; width: 100%; border: 2px solid #ddd; margin-top: 10px;"></div>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('admin.puntos-encuentro.index') }}" class="btn btn-danger">Cancelar</a>
</form>

<script>
    var mapa;
    var marcador;

    function initMap() {
        var ubicacionInicial = { lat: -0.9374805, lng: -78.6161327 };
        
        mapa = new google.maps.Map(document.getElementById('mapa'), {
            center: ubicacionInicial,
            zoom: 15
        });

        marcador = new google.maps.Marker({
            position: ubicacionInicial,
            map: mapa,
            draggable: true,
            title: "Arrastra para seleccionar ubicación"
        });

        marcador.addListener('dragend', function() {
            var posicion = marcador.getPosition();
            document.getElementById('latitud').value = posicion.lat();
            document.getElementById('longitud').value = posicion.lng();
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe-d3jhyJysjrOpa1iPvNlJDL6QHQMPfg&callback=initMap"></script>