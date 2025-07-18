@extends('layouts.appAdmin')

@section('content')

<div class="text-center mt-4 mb-3">
    <h2 class="fw-bold">Editar Zona de Riesgo</h2>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow p-4 mb-4 rounded bg-light">
                <form action="{{ route('ZonasRiesgo.update', $riesgos->id) }}" id="frm_editar_zona_riesgo" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- FORMULARIO -->
                        <div class="col-md-6">
                            <label for="nombre"><b>Nombre:</b></label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $riesgos->nombre) }}" class="form-control mb-3" placeholder="Ingrese el nombre de la zona">

                            <label for="descripcion"><b>Descripción:</b></label>
                            <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $riesgos->descripcion) }}" class="form-control mb-3" placeholder="Ingrese la descripción">

                            <label for="nivel"><b>Nivel:</b></label>
                            <select class="form-select mb-3" name="nivel" id="nivel">
                                <option value="" disabled {{ old('nivel', $riesgos->nivel) ? '' : 'selected' }}>Seleccione un nivel de riesgo</option>
                                <option value="Alto" {{ old('nivel', $riesgos->nivel) == 'Alto' ? 'selected' : '' }}>ALTO</option>
                                <option value="Medio" {{ old('nivel', $riesgos->nivel) == 'Medio' ? 'selected' : '' }}>MEDIO</option>
                                <option value="Bajo" {{ old('nivel', $riesgos->nivel) == 'Bajo' ? 'selected' : '' }}>BAJO</option>
                            </select>

                            @for($i = 1; $i <= 4; $i++)
                                <div class="mb-3">
                                    <label><b>COORDENADA N°{{ $i }}</b></label>
                                    <input type="number" name="latitud{{ $i }}" id="latitud{{ $i }}" value="{{ old('latitud'.$i, $riesgos->{'latitud'.$i}) }}" class="form-control mb-2" readonly placeholder="Latitud">
                                    <input type="number" name="longitud{{ $i }}" id="longitud{{ $i }}" value="{{ old('longitud'.$i, $riesgos->{'longitud'.$i}) }}" class="form-control" readonly placeholder="Longitud">
                                </div>
                            @endfor

                            <div class="text-center mt-4">
                                <button class="btn btn-success mb-2">Guardar cambios</button>
                                <a href="{{ route('ZonasRiesgo.index') }}" class="btn btn-secondary mb-2">Cancelar</a>
                                <button type="reset" class="btn btn-danger mb-2">Limpiar</button>
                            </div>
                        </div>

                        <!-- MAPA -->
                        <div class="col-md-6 d-flex align-items-center">
                            <div id="mapa-poligono" style="height: 600px; width: 100%; border: 2px solid blue; border-radius: 8px;"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script type="text/javascript">
    let mapaPoligono;
    let marcadores = [];
    let poligono = null;

    function initMap() {
        const centroInicial = { lat: -0.9374805, lng: -78.6161327 };

        mapaPoligono = new google.maps.Map(document.getElementById("mapa-poligono"), {
            zoom: 15,
            center: centroInicial,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        for (let i = 1; i <= 4; i++) {
            const lat = parseFloat(document.getElementById(`latitud${i}`).value);
            const lng = parseFloat(document.getElementById(`longitud${i}`).value);

            if (!isNaN(lat) && !isNaN(lng)) {
                const marcador = new google.maps.Marker({
                    position: { lat, lng },
                    map: mapaPoligono,
                    draggable: true,
                    label: `${i}`
                });

                marcador.addListener("dragend", function () {
                    const nuevaPos = this.getPosition();
                    actualizarInputsDeMarcador(i - 1, nuevaPos);
                    actualizarPoligono();
                });

                marcadores.push(marcador);
            }
        }

        actualizarPoligono();

        mapaPoligono.addListener("click", function (event) {
            if (marcadores.length >= 4) {
                alert("Solo se permiten 4 puntos para definir la zona.");
                return;
            }

            const index = marcadores.length;

            const nuevoMarcador = new google.maps.Marker({
                position: event.latLng,
                map: mapaPoligono,
                draggable: true,
                label: `${index + 1}`
            });

            actualizarInputsDeMarcador(index, event.latLng);

            nuevoMarcador.addListener("dragend", function () {
                const nuevaPos = this.getPosition();
                actualizarInputsDeMarcador(index, nuevaPos);
                actualizarPoligono();
            });

            marcadores.push(nuevoMarcador);
            actualizarPoligono();
        });
    }

    function actualizarInputsDeMarcador(index, latLng) {
        const latInput = document.getElementById(`latitud${index + 1}`);
        const lngInput = document.getElementById(`longitud${index + 1}`);
        latInput.value = latLng.lat().toFixed(7);
        lngInput.value = latLng.lng().toFixed(7);
    }

    function actualizarPoligono() {
        const coordenadas = marcadores.map(m => m.getPosition());

        if (poligono) {
            poligono.setMap(null);
        }

        if (coordenadas.length >= 3) {
            poligono = new google.maps.Polygon({
                paths: coordenadas,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#00FF00",
                fillOpacity: 0.35,
                map: mapaPoligono
            });
        }
    }

    function graficarZona() {
        actualizarPoligono();
    }
</script>

<script>
    $("#frm_editar_zona_riesgo").validate({
        rules: {
            "nombre": {
                required: true,
                minlength: 11,
                maxlength: 25,
                pattern: /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/
            },
            "descripcion": {
                required: true,
                minlength: 20,
                maxlength: 100
            },
            "nivel": {
                required: true
            },
            @for ($i = 1; $i <= 4; $i++)
                "latitud{{ $i }}": { required: true },
                "longitud{{ $i }}": { required: true },
            @endfor
        },
        messages: {
            "nombre": {
                required: "Por favor el Campo es obligatorio",
                minlength: "Debe ingresar mínimo 11 caracteres",
                maxlength: "Debe ingresar máximo 25 caracteres",
                pattern: "Solo se permiten letras y espacios"
            },
            "descripcion": {
                required: "Por favor el Campo es obligatorio",
                minlength: "Debe ingresar mínimo 20 caracteres",
                maxlength: "Debe ingresar máximo 100 caracteres"
            },
            "nivel": {
                required: "Por favor el Campo es obligatorio"
            }
        }
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV-hhnGIiWpn19hxGsr3NpUv7yFXaqFCU&callback=initMap" async defer></script>
@endsection
