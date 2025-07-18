@extends('layouts.appAdmin')
@section('content')

<h1>EDITAR PUNTO DE ENCUENTRO</h1>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow p-4 mb-4 rounded bg-light">
                <form action="{{ route('admin.puntos-encuentro.update', $punto->id) }}" id="frm_editar_punto_encuentro" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <label for=""><b>Nombre:</b></label>
                    <input type="text" name="nombre" id="nombre" value="{{ $punto->nombre }}" required class="form-control">
                    <br>
                    
                    <label for=""><b>Capacidad:</b></label>
                    <input type="number" name="capacidad" id="capacidad" value="{{ $punto->capacidad }}" required class="form-control">
                    <br>
                    
                    <label for=""><b>Responsable:</b></label>
                    <input type="text" name="responsable" id="responsable" value="{{ $punto->responsable }}" required class="form-control">
                    <br>
                    
                    <label for=""><b>Radio de Cobertura (metros):</b></label>
                    <input type="number" name="radio" id="radio" value="{{ $punto->radio }}" required class="form-control">
                    <br>
                    
                    <div class="mb-3">
                        <label for=""><b>Ubicación:</b></label>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Latitud:</label>
                                <input type="number" step="any" id="latitud" name="latitud" value="{{ $punto->latitud }}" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Longitud:</label>
                                <input type="number" step="any" id="longitud" name="longitud" value="{{ $punto->longitud }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div id="mapa" style="height: 300px; width: 100%; border: 2px solid #ddd; margin-top: 10px;"></div>
                    </div>
                    
                    <br>
                    <center>
                        <button class="btn btn-primary">
                            Actualizar
                        </button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{ route('admin.puntos-encuentro.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalGraficoCirculo" id="btn-ver-radio">
                            Ver Radio
                        </button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar el radio -->
<div class="modal fade" id="modalGraficoCirculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Radio de Cobertura del Punto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="mapa-circulo" style="height: 400px; width: 100%; border: 2px solid blue;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let mapa;
    let marcador;
    let circuloPrincipal;

    function initMap() {
        const ubicacionActual = {
            lat: parseFloat({{ $punto->latitud }}),
            lng: parseFloat({{ $punto->longitud }})
        };

        mapa = new google.maps.Map(document.getElementById("mapa"), {
            zoom: 15,
            center: ubicacionActual,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        marcador = new google.maps.Marker({
            position: ubicacionActual,
            map: mapa,
            draggable: true,
            title: "Arrastra para cambiar ubicación",
            icon: window.mapaIconos.obtenerAleatorio()
        });

        marcador.addListener('drag', function() {
            const posicion = marcador.getPosition();
            document.getElementById('latitud').value = posicion.lat().toFixed(7);
            document.getElementById('longitud').value = posicion.lng().toFixed(7);
            if (circuloPrincipal) {
                circuloPrincipal.setCenter(posicion);
            }
        });

        dibujarCirculoPrincipal();

        document.getElementById('radio').addEventListener('input', function() {
            dibujarCirculoPrincipal();
        });

        configurarMapaModal();
    }

    function dibujarCirculoPrincipal() {
        const radio = parseFloat(document.getElementById('radio').value);
        const centro = marcador.getPosition();

        if (circuloPrincipal) {
            circuloPrincipal.setRadius(radio);
            circuloPrincipal.setCenter(centro);
        } else {
            circuloPrincipal = new google.maps.Circle({
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                map: mapa,
                center: centro,
                radius: radio
            });
        }
    }

    function configurarMapaModal() {
        $('#modalGraficoCirculo').on('shown.bs.modal', function() {
            const ubicacionActual = marcador.getPosition();
            const radio = parseFloat(document.getElementById('radio').value);
            
            const mapaModal = new google.maps.Map(document.getElementById('mapa-circulo'), {
                center: ubicacionActual,
                zoom: 15
            });

            new google.maps.Marker({
                position: ubicacionActual,
                map: mapaModal,
                title: "{{ $punto->nombre }}",
                icon: window.mapaIconos.obtenerAleatorio()
            });

            new google.maps.Circle({
                strokeColor: "#0000FF",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#0000FF",
                fillOpacity: 0.35,
                map: mapaModal,
                center: ubicacionActual,
                radius: radio
            });
        });
    }
</script>

<script>
    $("#frm_editar_punto_encuentro").validate({
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