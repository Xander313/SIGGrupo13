@extends('layouts.appAdmin')

@section('content')

<div class="text-center mt-4 mb-3">
    <h2 class="fw-bold">Editar Zona de Riesgo</h2>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow p-4 mb-4 rounded bg-light">
                <div class="col-md-2"></div>
                    <form action="{{ route('ZonasRiesgo.update', $riesgos->id) }}" id="frm_editar_zona_riesgo" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="nombre"><b>Nombre:</b></label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $riesgos->nombre) }}" placeholder="Ingrese el nombre de la zona" class="form-control">
                        <br>

                        <label for="descripcion"><b>Descripción:</b></label>
                        <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $riesgos->descripcion) }}" placeholder="Ingrese la descripción para esta zona" class="form-control">
                        <br>

                        <div class="mb-3">
                            <label for="nivel" class="form-label"><b>Nivel de Riesgo:</b></label>
                            <select class="form-select" name="nivel" id="nivel">
                                <option value="" disabled {{ old('nivel', $riesgos->nivel) ? '' : 'selected' }}>Seleccione un nivel de riesgo</option>
                                <option value="Alto" {{ old('nivel', $riesgos->nivel) == 'Alto' ? 'selected' : '' }}>ALTO</option>
                                <option value="Medio" {{ old('nivel', $riesgos->nivel) == 'Medio' ? 'selected' : '' }}>MEDIO</option>
                                <option value="Bajo" {{ old('nivel', $riesgos->nivel) == 'Bajo' ? 'selected' : '' }}>BAJO</option>
                            </select>
                        </div>

                        {{-- Coordenadas con valores cargados --}}
                        @for($i = 1; $i <= 4; $i++)
                        <div class="row">
                            <div class="col-md-5">
                                <label><b>COORDENADA N°{{ $i }}</b></label><br><br>
                                <label for="latitud{{ $i }}"><b>Latitud</b></label><br>
                                <input type="number" step="any" name="latitud{{ $i }}" id="latitud{{ $i }}" 
                                       value="{{ old('latitud'.$i, $riesgos->{'latitud'.$i}) }}" 
                                       class="form-control" readonly 
                                       placeholder="Seleccione la latitud en el mapa">
                                <label for="longitud{{ $i }}"><b>Longitud</b></label><br>
                                <input type="number" step="any" name="longitud{{ $i }}" id="longitud{{ $i }}" 
                                       value="{{ old('longitud'.$i, $riesgos->{'longitud'.$i}) }}" 
                                       class="form-control" readonly 
                                       placeholder="Seleccione la longitud en el mapa">
                                <br>
                            </div>
                            <div class="col-md-7">
                                <br>
                                <div id="mapa{{ $i }}" style="border:2px solid white; height:200px;width:100%"></div>
                            </div>
                        </div>
                        @endfor

                        <br>
                        <center>
                            <button class="btn btn-success">
                                Guardar cambios
                            </button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('ZonasRiesgo.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn btn-danger">
                                Limpiar
                            </button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary" onclick="graficarZona();">
                                Graficar Zona de Riesgo
                            </button>
                        </center>
                    </form>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12">
                    <div id="mapa-poligono" style="height: 500px; width:100%; border:2px solid blue;"></div>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
            <script type="text/javascript">
                let mapaPoligono;
                let marcadores = [];

                function initMap() {
                    const centroInicial = { lat: -0.9374805, lng: -78.6161327 };
                    
                    // Inicializar mapa del polígono
                    mapaPoligono = new google.maps.Map(document.getElementById("mapa-poligono"), {
                        zoom: 15,
                        center: centroInicial,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

                    // Inicializar mapas para cada coordenada
                    for(let i = 1; i <= 4; i++) {
                        const latInput = document.getElementById(`latitud${i}`);
                        const lngInput = document.getElementById(`longitud${i}`);
                        
                        const lat = latInput.value ? parseFloat(latInput.value) : centroInicial.lat;
                        const lng = lngInput.value ? parseFloat(lngInput.value) : centroInicial.lng;
                        
                        const mapa = new google.maps.Map(document.getElementById(`mapa${i}`), {
                            center: { lat, lng },
                            zoom: 15,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        });

                        const marcador = new google.maps.Marker({
                            position: { lat, lng },
                            map: mapa,
                            title: `Seleccione la coordenada ${i}`,
                            draggable: true,
                            label: `${i}`
                        });

                        marcador.addListener('dragend', function() {
                            const pos = this.getPosition();
                            latInput.value = pos.lat().toFixed(7);
                            lngInput.value = pos.lng().toFixed(7);
                        });

                        marcadores.push(marcador);
                    }
                }

                function graficarZona() {
                    const coordenadas = [];
                    
                    for(let i = 1; i <= 4; i++) {
                        const lat = document.getElementById(`latitud${i}`).value;
                        const lng = document.getElementById(`longitud${i}`).value;
                        
                        if(lat && lng) {
                            coordenadas.push(new google.maps.LatLng(lat, lng));
                        }
                    }

                    if(coordenadas.length >= 3) {
                        // Limpiar polígonos anteriores
                        document.querySelectorAll('#mapa-poligono polygon').forEach(p => p.remove());
                        
                        new google.maps.Polygon({
                            paths: coordenadas,
                            strokeColor: "#FF0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: "#00FF00",
                            fillOpacity: 0.35,
                            map: mapaPoligono
                        });
                    } else {
                        alert("Se necesitan al menos 3 coordenadas para graficar la zona");
                    }
                }

                // Método personalizado para validar solo letras
                jQuery.validator.addMethod("soloLetras", function(value, element) {
                    return this.optional(element) || /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(value);
                }, "Solo se permiten letras y espacios");

                // Validación del formulario
                $("#frm_editar_zona_riesgo").validate({
                    rules: {
                        "nombre": {
                            required: true,
                            minlength: 11,
                            maxlength: 25,
                            soloLetras: true
                        },
                        "descripcion": {
                            required: true,
                            minlength: 20,
                            maxlength: 50
                        },
                        "nivel": {
                            required: true
                        },
                        "latitud1": {
                            required: true
                        },
                        "longitud1": {
                            required: true
                        },
                        "latitud2": {
                            required: true
                        },
                        "longitud2": {
                            required: true
                        },
                        "latitud3": {
                            required: true
                        },
                        "longitud3": {
                            required: true
                        },
                        "latitud4": {
                            required: true
                        },
                        "longitud4": {
                            required: true
                        }
                    },
                    messages: {
                        "nombre": {
                            required: "Por favor el Campo es obligatorio",
                            minlength: "Debe ingresar minimo 11 caracteres",
                            maxlength: "Debe ingresar maxima 25 caracteres",
                            soloLetras: "Solo se permiten letras y espacios"
                        },
                        "descripcion": {
                            required: "Por favor el Campo es obligatorio",
                            minlength: "Debe ingresar minimo 20 caracteres",
                            maxlength: "Debe ingresar maxima 50 caracteres"
                        },
                        "nivel": {
                            required: "Por favor el Campo es obligatorio"
                        },
                        "latitud1": {
                            required: "Por favor el Campo es obligatorio"
                        },
                        "longitud1": {
                            required: "Por favor el Campo es obligatorio"
                        },
                        "latitud2": {
                            required: "Por favor el Campo es obligatorio"
                        },
                        "longitud2": {
                            required: "Por favor el Campo es obligatorio"
                        },
                        "latitud3": {
                            required: "Por favor el Campo es obligatorio"
                        },
                        "longitud3": {
                            required: "Por favor el Campo es obligatorio"
                        },
                        "latitud4": {
                            required: "Por favor el Campo es obligatorio"
                        },
                        "longitud4": {
                            required: "Por favor el Campo es obligatorio"
                        }
                    }
                });
            </script>

            <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV-hhnGIiWpn19hxGsr3NpUv7yFXaqFCU&callback=initMap">
            </script>
        </div>
    </div>
</div>

@endsection