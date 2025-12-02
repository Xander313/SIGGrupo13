@extends('layouts.appAdmin')

@section('content')

<h1 class="text-center">Editar Tipo de Atracción</h1>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-6">

            <div class="card shadow p-4 mb-4 rounded bg-light">

                <form action="{{ route('types.update', $type->IdTipoAtraccion) }}" 
                      id="frm_type" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <label><b>Nombre del Tipo:</b></label>
                    <input type="text" name="NombreTipoAtraccion" 
                           class="form-control" 
                           value="{{ $type->NombreTipoAtraccion }}" 
                           required>
                    <br>

                    {{-- Popularidad --}}
                    <label><b>Nivel de Popularidad:</b></label>
                    <select name="NivelPopularidad" class="form-control" required>
                        <option value="Alto"  {{ $type->NivelPopularidad == 'Alto' ? 'selected' : '' }}>Alto</option>
                        <option value="Medio" {{ $type->NivelPopularidad == 'Medio' ? 'selected' : '' }}>Medio</option>
                        <option value="Bajo"  {{ $type->NivelPopularidad == 'Bajo' ? 'selected' : '' }}>Bajo</option>
                    </select>
                    <br>

                    {{-- Requiere Guía --}}
                    <label><b>¿Requiere Guía?</b></label>
                    <select name="RequiereGuia" class="form-control" required>
                        <option value="Si" {{ $type->RequiereGuia == 'Si' ? 'selected' : '' }}>Sí</option>
                        <option value="No" {{ $type->RequiereGuia == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                    <br>

                    <center>
                        <button class="btn btn-success">Actualizar</button>
                        &nbsp;&nbsp;
                        <a href="{{ route('types.index') }}" class="btn btn-secondary">Cancelar</a>
                        &nbsp;&nbsp;
                        <button type="reset" class="btn btn-danger">Restablecer</button>
                    </center>

                </form>

            </div>

        </div>
    </div>
</div>

{{-- VALIDACIÓN --}}
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
            required:"Seleccione un nivel"
        },
        RequiereGuia:{
            required:"Seleccione una opción"
        }
    }
});
</script>

@endsection
