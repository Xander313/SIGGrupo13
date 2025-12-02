@extends('layouts.appAdmin')

@section('content')

<h1 class="text-center">Registrar Nuevo Tipo de Atracción</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0" >
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-6">

            <div class="card shadow p-4 mb-4 rounded bg-light">

                <form action="{{ route('types.store') }}" id="frm_type" method="POST">
                    @csrf

                    {{-- Nombre --}}
                    <label><b>Nombre del Tipo de Atracción:</b></label>
                    <input type="text" name="NombreTipoAtraccion" class="form-control" 
                           placeholder="Ej: Cascada, Museo, Reserva Natural" required>
                    <br>

                    {{-- Popularidad --}}
                    <label><b>Nivel de Popularidad:</b></label>
                    <select name="NivelPopularidad" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <option value="Alto">Alto</option>
                        <option value="Medio">Medio</option>
                        <option value="Bajo">Bajo</option>
                    </select>
                    <br>

                    {{-- Requiere Guía --}}
                    <label><b>¿Requiere Guía?</b></label>
                    <select name="RequiereGuia" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <option value="Si">Sí</option>
                        <option value="No">No</option>
                    </select>
                    <br>

                    <center>
                        <button class="btn btn-success">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="{{ route('types.index') }}" class="btn btn-secondary">Cancelar</a>
                        &nbsp;&nbsp;
                        <button type="reset" class="btn btn-danger">Limpiar</button>
                    </center>

                </form>

            </div>

        </div>
    </div>
</div>

{{-- Validación con jQuery --}}
<script>
$("#frm_type").validate({
    rules:{
        NombreTipoAtraccion:{
            required:true,
            minlength:3,
            maxlength:150
        },
        NivelPopularidad:{
            required:true
        },
        RequiereGuia:{
            required:true
        }
    },
    messages:{
        NombreTipoAtraccion:{
            required:"Este campo es obligatorio",
            minlength:"Debe tener al menos 3 caracteres",
            maxlength:"Máximo 150 caracteres"
        },
        NivelPopularidad:{
            required:"Seleccione un nivel de popularidad"
        },
        RequiereGuia:{
            required:"Seleccione una opción"
        }
    }
});
</script>

@endsection
