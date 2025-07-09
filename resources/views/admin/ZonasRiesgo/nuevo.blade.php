    
@extends('layouts.appAdmin')

@section('content')
<div class="text-center mt-4 mb-3">
    <h2 class="fw-bold">Registrar Nueva Zona de Riesgo</h2>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow p-4 mb-4 rounded bg-light">
            <div class="col-md-2"></div>
                <form action="{{ route('ZonasRiesgo.store') }}"  method="POST">
                    @csrf
                    <label for=""><b>Nombre:</b></label>
                    <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre de la zona " required class="form-control">
                    <br>
                    <label for=""><b>Descripción:</b></label>
                    <input type="text" name="descripcion" id="descripcion" placeholder="Ingrese la descripcion para esta zona" required class="form-control" >
                    <br>
                    <div class="mb-3">
                        <label for="nivel" class="form-label"><b>Nivel:</b></label>
                                <select class="form-select" name="nivel" id="nivel">
                                    <option value="" disabled selected>Seleccione un nivel de riesgo</option>
                                    <option value="Alto">ALTO</option>
                                    <option value="Medio">MEDIO</option>
                                    <option value="Bajo">BAJO</option>
                                </select>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label for=""><b>COORDENADA N°1</b></label><br><br>
                            <label for=""><b>Latitud</b></label><br>
                            <input type="number" name="latitud1" id="latitud1" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                            <label for=""><b>Longitud</b></label><br>
                            <input type="number" name="longitud1" id="longitud1" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                            <br>
                        </div>
                        <div class="col-md-7">
                        <br>

                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-5">
                            <label for=""><b>COORDENADA N°2</b></label><br><br>
                            <label for=""><b>Latitud</b></label><br>
                            <input type="number" name="latitud2" id="latitud2" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                            <label for=""><b>Longitud</b></label><br>
                            <input type="number" name="longitud2" id="longitud2" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                            <br>
                        </div>
                        <div class="col-md-7">
                        <br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label for=""><b>COORDENADA N°3</b></label><br><br>
                            <label for=""><b>Latitud</b></label><br>
                            <input type="number" name="latitud3" id="latitud3" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                            <label for=""><b>Longitud</b></label><br>
                            <input type="number" name="longitud3" id="longitud3" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                            <br>
                        </div>
                        <div class="col-md-7">
                        <br>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label for=""><b>COORDENADA N°4</b></label><br><br>
                            <label for=""><b>Latitud</b></label><br>
                            <input type="number" name="latitud4" id="latitud4" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                            <label for=""><b>Longitud</b></label><br>
                            <input type="number" name="longitud4" id="longitud4" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                            <br>
                        </div>
                        <div class="col-md-7">
                        <br>

                        </div>
                    </div>
                    <br>
                    <center>
                        <button class="btn btn-success">
                            Guardar
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


@endsection