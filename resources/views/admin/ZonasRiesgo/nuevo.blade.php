    
@extends('layouts.appAdmin')

@section('content')
<div class="text-center mt-4 mb-3">
    <h2 class="fw-bold">Registrar Nueva Zona de Riesgo</h2>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow p-4 mb-4 rounded bg-light">
            <form action="{{ route('ZonasRiesgo.store') }}" id="frm_nuevazona_riesgo" method="POST">
                @csrf
                <div class="row">
                    
                    <div class="col-md-6">
                        <label for="nombre"><b>Nombre:</b></label>
                        <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre de la zona" required class="form-control mb-3">

                        <label for="descripcion"><b>Descripción:</b></label>
                        <input type="text" name="descripcion" id="descripcion" placeholder="Ingrese la descripción" required class="form-control mb-3">

                        <label for="nivel"><b>Nivel:</b></label>
                        <select class="form-select mb-3" name="nivel" id="nivel" required>
                            <option value="" disabled selected>Seleccione un nivel de riesgo</option>
                            <option value="Alto">ALTO</option>
                            <option value="Medio">MEDIO</option>
                            <option value="Bajo">BAJO</option>
                        </select>

                        @for ($i = 1; $i <= 4; $i++)
                            <div class="mb-3">
                                <label><b>COORDENADA N°{{ $i }}</b></label>
                                <input type="number" name="latitud{{ $i }}" id="latitud{{ $i }}" class="form-control mb-2" readonly placeholder="Latitud">
                                <input type="number" name="longitud{{ $i }}" id="longitud{{ $i }}" class="form-control" readonly placeholder="Longitud">
                            </div>
                        @endfor

                        <div class="text-center mt-4">
                            <button class="btn btn-success">Guardar</button>
                            <a href="{{ route('ZonasRiesgo.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="reset" class="btn btn-danger">Limpiar</button>
                        </div>
                    </div>

            
                    <div class="col-md-6 d-flex align-items-center">
                        <div id="mapa-poligono" style="height: 600px; width: 100%; border: 2px solid blue; border-radius: 8px;"></div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>



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

        function actualizarPoligono() {
            const coordenadas = marcadores.map(m => m.getPosition());

            // Limpia el polígono anterior
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

        function actualizarInputsDeMarcador(index, latLng) {
            const latInput = document.getElementById(`latitud${index + 1}`);
            const lngInput = document.getElementById(`longitud${index + 1}`);
            latInput.value = latLng.lat().toFixed(7);
            lngInput.value = latLng.lng().toFixed(7);
        }

    </script>
    <script>
        $("#frm_nuevazona_riesgo").validate({
            rules:{
                "nombre":{
                    required:true,
                    minlength:11,// cuenta caracteres 
                    maxlength:25,// caracteres maximos
                    pattern: /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/ 
                },
                "descripcion":{
                    required:true,
                    minlength:20,// cuenta caracteres 
                    maxlength:100// caracteres maximos
                },
                "nivel":{
                    required:true
                },
                "latitud1":{
                    required:true
                },
                "longitud1":{
                    required:true,
                },
                "latitud2":{
                    required:true
                },
                "longitud2":{
                    required:true,
                },
                "latitud3":{
                    required:true
                },
                "longitud3":{
                    required:true,
                },
                "latitud4":{
                    required:true
                },
                "longitud4":{
                    required:true,
                },

            },
            messages:{
                "nombre":{
                    required:"Por favor el Campo es obligatorio",
                    minlength:"Debe ingresar minimo 11 caracteres",// cuenta caracteres 
                    maxlength:"Debe ingresar maxima 25 caracteres",// caracteres maximos
                    pattern: "Solo se permiten letras y espacios"
                },
                "descripcion":{
                    required:"Por favor el Campo es obligatorio",
                    minlength:"Debe ingresar minimo 20 caracteres",// cuenta caracteres 
                    maxlength:"Debe ingresar maxima 100   caracteres"// caracteres maximos
                },
                "nivel":{
                    required:"Por favor el Campo es obligatorio"
                },
                "latitud1":{
                    required:"Por favor el Campo es obligatorio"
                },
                "longitud1":{
                    required:"Por favor el Campo es obligatorio"
                },
                "latitud2":{
                    required:"Por favor el Campo es obligatorio"
                },
                "longitud2":{
                    required:"Por favor el Campo es obligatorio"
                },
                "latitud3":{
                    required:"Por favor el Campo es obligatorio"
                },
                "longitud3":{
                    required:"Por favor el Campo es obligatorio"
                },
                "latitud4":{
                    required:"Por favor el Campo es obligatorio"
                },
                "longitud4":{
                    required:"Por favor el Campo es obligatorio"
                },
                
            }
        });
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV-hhnGIiWpn19hxGsr3NpUv7yFXaqFCU&callback=initMap" async defer></script>

@endsection