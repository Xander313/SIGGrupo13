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
                    <form action="{{ route('ZonasRiesgo.update', $riesgos->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="nombre"><b>Nombre:</b></label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $riesgos->nombre) }}" placeholder="Ingrese el nombre de la zona" required class="form-control">
                        <br>

                        <label for="descripcion"><b>Descripción:</b></label>
                        <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $riesgos->descripcion) }}" placeholder="Ingrese la descripción para esta zona" required class="form-control">
                        <br>

                        <div class="mb-3">
                            <label for="nivel" class="form-label"><b>Nivel de Riesgo:</b></label>
                            <select class="form-select" name="nivel" id="nivel" required>
                                <option value="" disabled {{ old('nivel', $riesgos->nivel) ? '' : 'selected' }}>Seleccione un nivel de riesgo</option>
                                <option value="Alto" {{ old('nivel', $riesgos->nivel) == 'Alto' ? 'selected' : '' }}>ALTO</option>
                                <option value="Medio" {{ old('nivel', $riesgos->nivel) == 'Medio' ? 'selected' : '' }}>MEDIO</option>
                                <option value="Bajo" {{ old('nivel', $riesgos->nivel) == 'Bajo' ? 'selected' : '' }}>BAJO</option>
                            </select>
                        </div>

                        {{-- Coordenadas con valores cargados --}}
                        <div class="row">
                            <div class="col-md-5">
                                <label><b>COORDENADA N°1</b></label><br><br>
                                <label for="latitud1"><b>Latitud</b></label><br>
                                <input type="number" step="any" name="latitud1" id="latitud1" value="{{ old('latitud1', $riesgos->latitud1) }}" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                                <label for="longitud1"><b>Longitud</b></label><br>
                                <input type="number" step="any" name="longitud1" id="longitud1" value="{{ old('longitud1', $riesgos->longitud1) }}" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                                <br>
                            </div>
                            <div class="col-md-7">
                                <br>
                                <div id="mapa1" style="border:2px solid white; height:200px;width:100%"></div>
                            </div>
                        </div>

                        {{-- Coordenada 2 --}}
                        <div class="row">
                            <div class="col-md-5">
                                <label><b>COORDENADA N°2</b></label><br><br>
                                <label for="latitud2"><b>Latitud</b></label><br>
                                <input type="number" step="any" name="latitud2" id="latitud2" value="{{ old('latitud2', $riesgos->latitud2) }}" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                                <label for="longitud2"><b>Longitud</b></label><br>
                                <input type="number" step="any" name="longitud2" id="longitud2" value="{{ old('longitud2', $riesgos->longitud2) }}" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                                <br>
                            </div>
                            <div class="col-md-7">
                                <br>
                                <div id="mapa2" style="border:2px solid white; height:200px;width:100%"></div>
                            </div>
                        </div>

                        {{-- Coordenada 3 --}}
                        <div class="row">
                            <div class="col-md-5">
                                <label><b>COORDENADA N°3</b></label><br><br>
                                <label for="latitud3"><b>Latitud</b></label><br>
                                <input type="number" step="any" name="latitud3" id="latitud3" value="{{ old('latitud3', $riesgos->latitud3) }}" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                                <label for="longitud3"><b>Longitud</b></label><br>
                                <input type="number" step="any" name="longitud3" id="longitud3" value="{{ old('longitud3', $riesgos->longitud3) }}" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                                <br>
                            </div>
                            <div class="col-md-7">
                                <br>
                                <div id="mapa3" style="border:2px solid white; height:200px;width:100%"></div>
                            </div>
                        </div>

                        {{-- Coordenada 4 --}}
                        <div class="row">
                            <div class="col-md-5">
                                <label><b>COORDENADA N°4</b></label><br><br>
                                <label for="latitud4"><b>Latitud</b></label><br>
                                <input type="number" step="any" name="latitud4" id="latitud4" value="{{ old('latitud4', $riesgos->latitud4) }}" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                                <label for="longitud4"><b>Longitud</b></label><br>
                                <input type="number" step="any" name="longitud4" id="longitud4" value="{{ old('longitud4', $riesgos->longitud4) }}" class="form-control" readonly placeholder="Seleccione la longitud en el mapa">
                                <br>
                            </div>
                            <div class="col-md-7">
                                <br>
                                <div id="mapa4" style="border:2px solid white; height:200px;width:100%"></div>
                            </div>
                        </div>
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

            <script type="text/javascript">
                var mapaPoligono;

                window.initMap = function () {
                    var latitud_longitud = new google.maps.LatLng(-0.9374805, -78.6161327);

                    // COORDENADA 1
                    var mapa1 = new google.maps.Map(document.getElementById('mapa1'), {
                        center: latitud_longitud,
                        zoom: 15,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var marcador1 = new google.maps.Marker({
                        position: new google.maps.LatLng(parseFloat(document.getElementById("latitud1").value) || -0.9374805, parseFloat(document.getElementById("longitud1").value) || -78.6161327),
                        map: mapa1,
                        title: "Seleccione la coordenada 1",
                        draggable: true
                    });
                    google.maps.event.addListener(marcador1, 'dragend', function () {
                        document.getElementById("latitud1").value = this.getPosition().lat();
                        document.getElementById("longitud1").value = this.getPosition().lng();
                    });

                    // COORDENADA 2
                    var mapa2 = new google.maps.Map(document.getElementById('mapa2'), {
                        center: new google.maps.LatLng(parseFloat(document.getElementById("latitud2").value) || -0.9374805, parseFloat(document.getElementById("longitud2").value) || -78.6161327),
                        zoom: 15,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var marcador2 = new google.maps.Marker({
                        position: new google.maps.LatLng(parseFloat(document.getElementById("latitud2").value) || -0.9374805, parseFloat(document.getElementById("longitud2").value) || -78.6161327),
                        map: mapa2,
                        title: "Seleccione la coordenada 2",
                        draggable: true
                    });
                    google.maps.event.addListener(marcador2, 'dragend', function () {
                        document.getElementById("latitud2").value = this.getPosition().lat();
                        document.getElementById("longitud2").value = this.getPosition().lng();
                    });

                    // COORDENADA 3
                    var mapa3 = new google.maps.Map(document.getElementById('mapa3'), {
                        center: new google.maps.LatLng(parseFloat(document.getElementById("latitud3").value) || -0.9374805, parseFloat(document.getElementById("longitud3").value) || -78.6161327),
                        zoom: 15,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var marcador3 = new google.maps.Marker({
                        position: new google.maps.LatLng(parseFloat(document.getElementById("latitud3").value) || -0.9374805, parseFloat(document.getElementById("longitud3").value) || -78.6161327),
                        map: mapa3,
                        title: "Seleccione la coordenada 3",
                        draggable: true
                    });
                    google.maps.event.addListener(marcador3, 'dragend', function () {
                        document.getElementById("latitud3").value = this.getPosition().lat();
                        document.getElementById("longitud3").value = this.getPosition().lng();
                    });

                    // COORDENADA 4
                    var mapa4 = new google.maps.Map(document.getElementById('mapa4'), {
                        center: new google.maps.LatLng(parseFloat(document.getElementById("latitud4").value) || -0.9374805, parseFloat(document.getElementById("longitud4").value) || -78.6161327),
                        zoom: 15,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var marcador4 = new google.maps.Marker({
                        position: new google.maps.LatLng(parseFloat(document.getElementById("latitud4").value) || -0.9374805, parseFloat(document.getElementById("longitud4").value) || -78.6161327),
                        map: mapa4,
                        title: "Seleccione la coordenada 4",
                        draggable: true
                    });
                    google.maps.event.addListener(marcador4, 'dragend', function () {
                        document.getElementById("latitud4").value = this.getPosition().lat();
                        document.getElementById("longitud4").value = this.getPosition().lng();
                    });

                    // Mapa para el polígono
                    mapaPoligono = new google.maps.Map(document.getElementById("mapa-poligono"), {
                        zoom: 15,
                        center: new google.maps.LatLng(parseFloat(document.getElementById("latitud1").value) || -0.9374805, parseFloat(document.getElementById("longitud1").value) || -78.6161327),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                };

                function graficarZona() {
                    var coordenada1 = new google.maps.LatLng(
                        document.getElementById('latitud1').value,
                        document.getElementById('longitud1').value
                    );
                    var coordenada2 = new google.maps.LatLng(
                        document.getElementById('latitud2').value,
                        document.getElementById('longitud2').value
                    );
                    var coordenada3 = new google.maps.LatLng(
                        document.getElementById('latitud3').value,
                        document.getElementById('longitud3').value
                    );
                    var coordenada4 = new google.maps.LatLng(
                        document.getElementById('latitud4').value,
                        document.getElementById('longitud4').value
                    );

                    var coordenadas = [coordenada1, coordenada2, coordenada3, coordenada4];

                    var poligono = new google.maps.Polygon({
                        paths: coordenadas,
                        strokeColor: "#FF0000",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "#00FF00",
                        fillOpacity: 0.35,
                    });

                    poligono.setMap(mapaPoligono);
                }
            </script>

            <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV-hhnGIiWpn19hxGsr3NpUv7yFXaqFCU&callback=initMap">
            </script>
            </div>
        </div>
    </div>
</div>

@endsection