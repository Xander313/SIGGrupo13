@extends('layouts.appAdmin')
@section('content')

<h1>NUEVO PUNTO DE ENCUENTRO</h1>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow p-4 mb-4 rounded bg-light">
                <form action="{{ route('admin.puntos-encuentro.store') }}" id="frm_punto_encuentro" method="POST">
                    @csrf
                    
                    <label for=""><b>Nombre:</b></label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre del punto" required class="form-control">
                    <br>
                    
                    <label for=""><b>Capacidad:</b></label>
                    <input type="number" name="capacidad" id="capacidad" placeholder="Capacidad de personas" required class="form-control">
                    <br>
                    
                    <label for=""><b>Responsable:</b></label>
                    <input type="text" name="responsable" id="responsable" placeholder="Nombre del responsable" required class="form-control">
                    <br>
                    
                    <label for=""><b>Radio de Cobertura (metros):</b></label>
                    <input type="number" name="radio" id="radio" value="50" placeholder="Radio en metros" required class="form-control">
                    <br>
                    
                    <div class="mb-3">
                        <label for=""><b>Ubicación:</b></label>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Latitud:</label>
                                <input type="number" step="any" id="latitud" value="-0.9374805" name="latitud" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Longitud:</label>
                                <input type="number" step="any" id="longitud" value="-78.6161327" name="longitud" class="form-control" readonly>
                            </div>
                        </div>
                        <div id="mapa" style="height: 500px; width: 100%; border: 2px solid #ddd; margin-top: 10px;"></div>
                    </div>
                    
                    <br>
                    <center>
                        <button class="btn btn-success">
                            Guardar
                        </button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{ route('admin.puntos-encuentro.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="reset" class="btn btn-danger">
                            Limpiar
                        </button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let mapa;
    let marcador;
    let circulo;

    function initMap() {
        const ubicacionInicial = { lat: -0.9374805, lng: -78.6161327 };
        
        mapa = new google.maps.Map(document.getElementById("mapa"), {
            zoom: 15,
            center: ubicacionInicial,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        marcador = new google.maps.Marker({
            position: ubicacionInicial,
            map: mapa,
            draggable: true,
            title: "Arrastra para seleccionar ubicación",
            icon: window.mapaIconos.obtenerAleatorio()
        });

        circulo = new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
            map: mapa,
            center: ubicacionInicial,
            radius: parseFloat(document.getElementById('radio').value)
        });

        marcador.addListener('drag', function() {
            const nuevaPosicion = marcador.getPosition();
            document.getElementById('latitud').value = nuevaPosicion.lat().toFixed(7);
            document.getElementById('longitud').value = nuevaPosicion.lng().toFixed(7);
            circulo.setCenter(nuevaPosicion);
        });

        document.getElementById('radio').addEventListener('input', function() {
            circulo.setRadius(parseFloat(this.value) || 50);
        });
    }
</script>

<script>
    $("#frm_punto_encuentro").validate({
        rules:{
            "nombre":{
                required:true,
                minlength:5,
                maxlength:30,
                pattern: /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/
            },
            "capacidad":{
                required:true,
                min:1,
                max:99999
            },
            "responsable":{
                required:true,
                minlength:5,
                maxlength:30,
                pattern: /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/
            },
            "radio":{
                required:true,
                min:1,
                max:1000
            },
            "latitud":{
                required:true
            },
            "longitud":{
                required:true
            }
        },
        messages:{
            "nombre":{
                required:"Por favor el Campo es obligatorio",
                minlength:"Debe ingresar minimo 5 caracteres",
                maxlength:"Debe ingresar maxima 30 caracteres",
                pattern: "Solo se permiten letras y espacios"
            },
            "capacidad":{
                required:"Por favor el Campo es obligatorio",
                min:"La capacidad mínima es 1 persona",
                max:"La capacidad máxima es 99999 personas"
            },
            "responsable":{
                required:"Por favor el Campo es obligatorio",
                minlength:"Debe ingresar minimo 5 caracteres",
                maxlength:"Debe ingresar maxima 30 caracteres",
                pattern: "Solo se permiten letras y espacios"
            },
            "radio":{
                required:"Por favor el Campo es obligatorio",
                min:"El radio mínimo es 1 metro",
                max:"El radio máximo es 1000 metros"
            },
            "latitud":{
                required:"Por favor el Campo es obligatorio"
            },
            "longitud":{
                required:"Por favor el Campo es obligatorio"
            }
        }
    });
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7lFQ6zmecboYhiJaNi43FELV1wO3jSkY&callback=initMapIconos" async defer></script>

@endsection