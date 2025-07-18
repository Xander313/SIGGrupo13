
@extends('layouts.appAdmin')
@section('content')


<!-- 1. jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- 2. jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/localization/messages_es.min.js"></script>


<br><br><br><br><br>
<div class='row'>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('zonas-seguras.store') }}" method="POST" id="formZonaSegura">
            @csrf
            <h3><b>Registrar Nueva Zona Segura</b></h3>
            <hr>

            <label for="nombre"><b>Nombre de la zona:</b></label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
            <br>
            <label for="tipo_seguridad"><b>Tipo de seguridad:</b></label>
            <select name="tipo_seguridad" id="tipo_seguridad" class="form-select" required>
                <option value="">--- Seleccione ---</option>
                <option value="Refugio">Refugio</option>
                <option value="Zona de evacuación">Zona de evacuación</option>
                <option value="Centro de salud">Centro de salud</option>
            </select>
            <br>
            <label for="radio"><b>Radio (en metros):</b></label>
            <input type="number" name="radio" id="radio" value="100" class="form-control" required>

            <label><b>Coordenadas centrales:</b></label>
            <input type="text" name="latitud" id="latitud" value="-0.9374805" class="form-control" placeholder="Latitud" readonly required>
            <input type="text" name="longitud" id="longitud" value="-78.6161327" class="form-control" placeholder="Longitud" readonly required>

            <div id="mapa2" style="height: 500px; width: 100%; border: 3px solid #2563eb; margin-top: 15px; border-radius: 6px;"></div>

            <br>
            <center>
                <button type="reset" class="btn btn-danger">Limpiar</button>
                <button type="submit" class="btn btn-success">Guardar Zona</button>
            </center>
        </form>
    </div>
</div>

<style>
    .error {
      color: red;
    }
    
    .form-control.error {
      border: 1px solid red;
    }
</style>


<script>
    $("#formZonaSegura").validate({
        rules: {
            nombre: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            tipo_seguridad: {
                required: true
            },
            radio: {
                required: true,
                number: true,
                min: 10,
                max: 1000
            },
            latitud: {
                required: true,
                number: true,
                min: -90,
                max: 90
            },
            longitud: {
                required: true,
                number: true,
                min: -180,
                max: 180
            }
        },
        messages: {
            nombre: {
                required: "Por favor, ingresa el nombre de la zona.",
                minlength: "El nombre debe tener al menos 3 caracteres.",
                maxlength: "El nombre no debe exceder los 50 caracteres."
            },
            tipo_seguridad: {
                required: "Selecciona el tipo de seguridad correspondiente."
            },
            radio: {
                required: "Indica el radio en metros.",
                number: "Solo se permiten valores numéricos.",
                min: "El radio mínimo permitido es 10 metros.",
                max: "El radio máximo permitido es 1000 metros."
            },
            latitud: {
                required: "La latitud es obligatoria.",
                number: "Debe ser un número válido.",
                min: "La latitud mínima es -90.",
                max: "La latitud máxima es 90."
            },
            longitud: {
                required: "La longitud es obligatoria.",
                number: "Debe ser un número válido.",
                min: "La longitud mínima es -180.",
                max: "La longitud máxima es 180."
            }
        },
        errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>



<script>
function initMap() {
    const defaultCoords = { lat: -0.9374805, lng: -78.6161327 };

    const mapa = new google.maps.Map(document.getElementById('mapa2'), {
        center: defaultCoords,
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    const marker = new google.maps.Marker({
        position: defaultCoords,
        map: mapa,
        draggable: true,
        title: "Arrastra para definir la ubicación"
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7lFQ6zmecboYhiJaNi43FELV1wO3jSkY&callback=initMapIconos" async defer></script>


@endsection


