<!-- 1. jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- 2. jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/localization/messages_es.min.js"></script>

<!-- 3. Bootstrap CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- 4. Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<!-- 5. DataTables core -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json"></script>

<!-- 6. DataTables Buttons (exportación e impresión) -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>

<!-- 7. Bootstrap FileInput -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.4/css/fileinput.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.4/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.4/js/locales/es.min.js"></script>

<!-- 8. SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe-d3jhyJysjrOpa1iPvNlJDL6QHQMPfg&libraries=places&callback=initMap"></script>


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

