@extends('layouts.appAdmin')

@section('content')

<h1 class="text-center">Registrar Nuevo Lugar Turístico</h1>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow p-4 mb-4 rounded bg-light">
                
                <form action="{{ route('zones.store') }}" id="frm_zone" method="POST">
                    @csrf

                    {{-- Nombre del Lugar --}}
                    <label><b>Nombre del Lugar:</b></label>
                    <input type="text" name="NombreLugar" 
                           class="form-control" required 
                           placeholder="Ej: Laguna del Quilotoa">
                    <br>

                    {{-- Provincia --}}
                    <label><b>Provincia:</b></label>
                    <select name="IdProvincia" class="form-control" required>
                        <option value="">Seleccione una provincia...</option>
                        @foreach($provinces as $prov)
                            <option value="{{ $prov->IdProvincia }}">
                                {{ $prov->NombreProvincia }}
                            </option>
                        @endforeach
                    </select>
                    <br>

                    {{-- Tipo de Atracción --}}
                    <label><b>Tipo de Atracción:</b></label>
                    <select name="IdTipoAtraccion" class="form-control" required>
                        <option value="">Seleccione el tipo...</option>
                        @foreach($types as $type)
                            <option value="{{ $type->IdTipoAtraccion }}">
                                {{ $type->NombreTipoAtraccion }}
                            </option>
                        @endforeach
                    </select>
                    <br>

                    {{-- Año de Creación --}}
                    <label><b>Año de Creación:</b></label>
                    <input type="number" name="AnioCreacion" 
                           class="form-control" required
                           placeholder="Ej: 1998">
                    <br>

                    {{-- Accesibilidad --}}
                    <label><b>Accesibilidad:</b></label>
                    <select name="Accesibilidad" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <option value="Fácil">Fácil</option>
                        <option value="Difícil">Difícil</option>
                    </select>
                    <br>

                    {{-- Descripción --}}
                    <label><b>Descripción:</b></label>
                    <textarea name="Descripcion" rows="4" 
                              class="form-control" required></textarea>
                    <br>

                    {{-- Ubicación (lat/lng) --}}
                    <div class="mb-3">
                        <label><b>Ubicación en el Mapa:</b></label>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Latitud:</label>
                                <input type="number" step="any" id="latitud" 
                                       name="Latitud" value="-0.180653" 
                                       class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Longitud:</label>
                                <input type="number" step="any" id="longitud" 
                                       name="Longitud" value="-78.467834" 
                                       class="form-control" readonly>
                            </div>
                        </div>

                        <div id="mapa" 
                             style="height: 400px; width: 100%; border: 2px solid #ccc; margin-top: 10px;">
                        </div>
                    </div>

                    <center>
                        <button class="btn btn-success">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="{{ route('zones.index') }}" class="btn btn-secondary">Cancelar</a>
                        &nbsp;&nbsp;
                        <button type="reset" class="btn btn-danger">Limpiar</button>
                    </center>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- GOOGLE MAPS SÓLO MARCADOR --}}
<script>
let mapa;
let marcador;

function initMap() {

    const posicionInicial = { lat: -0.180653, lng: -78.467834 };  // Quito por defecto

    mapa = new google.maps.Map(document.getElementById("mapa"), {
        zoom: 14,
        center: posicionInicial,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    marcador = new google.maps.Marker({
        position: posicionInicial,
        map: mapa,
        draggable: true,
        title: "Arrastra para seleccionar ubicación"
    });

    marcador.addListener('drag', function() {
        const p = marcador.getPosition();
        document.getElementById('latitud').value = p.lat().toFixed(7);
        document.getElementById('longitud').value = p.lng().toFixed(7);
    });
}
</script>

{{-- Google Maps API --}}
<script 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7lFQ6zmecboYhiJaNi43FELV1wO3jSkY&callback=initMap" 
async defer></script>
<script>
$("#frm_zone").validate({
    rules: {
        NombreLugar: {
            required: true,
            minlength: 3,
            maxlength: 200
        },
        IdProvincia: {
            required: true
        },
        IdTipoAtraccion: {
            required: true
        },
        AnioCreacion: {
            required: true,
            digits: true,
            min: 1,
            max: new Date().getFullYear()
        },
        Accesibilidad: {
            required: true
        },
        Descripcion: {
            required: true,
            minlength: 5,
            maxlength: 2000
        },
        Latitud: {
            required: true,
            number: true
        },
        Longitud: {
            required: true,
            number: true
        }
    },
    messages: {
        NombreLugar: {
            required: "El nombre del lugar es obligatorio",
            minlength: "Debe tener al menos 3 caracteres",
            maxlength: "Máximo 200 caracteres"
        },
        IdProvincia: {
            required: "Debe seleccionar una provincia"
        },
        IdTipoAtraccion: {
            required: "Debe seleccionar un tipo de atracción"
        },
        AnioCreacion: {
            required: "El año de creación es obligatorio",
            digits: "Debe contener solo números",
            min: "El año debe ser mayor que 0",
            max: "El año no puede ser mayor al año actual"
        },
        Accesibilidad: {
            required: "Seleccione un nivel de accesibilidad"
        },
        Descripcion: {
            required: "La descripción es obligatoria",
            minlength: "Debe contener al menos 5 caracteres",
            maxlength: "Máximo 2000 caracteres"
        },
        Latitud: {
            required: "Debe seleccionar una ubicación en el mapa",
            number: "Debe tener formato numérico"
        },
        Longitud: {
            required: "Debe seleccionar una ubicación en el mapa",
            number: "Debe tener formato numérico"
        }
    }
});
</script>

@endsection
