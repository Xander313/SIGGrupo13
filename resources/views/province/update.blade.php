@extends('layouts.appAdmin')

@section('content')

<h1 class="text-center">Editar Provincia</h1>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-6">

            <div class="card shadow p-4 mb-4 rounded bg-light">

                <form action="{{ route('provinces.update', $province->IdProvincia) }}" 
                      id="frm_province" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <label><b>Nombre de la Provincia:</b></label>
                    <input type="text" name="NombreProvincia" 
                           value="{{ $province->NombreProvincia }}"
                           class="form-control" required>
                    <br>

                    {{-- Capital --}}
                    <label><b>Capital:</b></label>
                    <input type="text" name="Capital" 
                           value="{{ $province->Capital }}"
                           class="form-control" required>
                    <br>

                    {{-- Población --}}
                    <label><b>Población:</b></label>
                    <input type="number" name="Poblacion" 
                           value="{{ $province->Poblacion }}"
                           class="form-control" min="1" required>
                    <br>

                    {{-- Clima --}}
                    <label><b>Clima Predominante:</b></label>
                    <input type="text" name="ClimaPredominante" 
                           value="{{ $province->ClimaPredominante }}"
                           class="form-control" required>
                    <br>

                    <center>
                        <button class="btn btn-success">Actualizar</button>
                        &nbsp;&nbsp;
                        <a href="{{ route('provinces.index') }}" class="btn btn-secondary">Cancelar</a>
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
$("#frm_province").validate({
    rules:{
        NombreProvincia:{
            required:true,
            minlength:3,
            maxlength:100
        },
        Capital:{
            required:true,
            minlength:3,
            maxlength:100
        },
        Poblacion:{
            required:true,
            min:1
        },
        ClimaPredominante:{
            required:true,
            minlength:3,
            maxlength:100
        }
    },
    messages:{
        NombreProvincia:{
            required:"Este campo es obligatorio",
            minlength:"Debe tener mínimo 3 caracteres",
            maxlength:"Máximo 100 caracteres"
        },
        Capital:{
            required:"Este campo es obligatorio",
            minlength:"Debe tener mínimo 3 caracteres",
            maxlength:"Máximo 100 caracteres"
        },
        Poblacion:{
            required:"La población es obligatoria",
            min:"Debe ser mayor a 0"
        },
        ClimaPredominante:{
            required:"Este campo es obligatorio",
            minlength:"Debe tener mínimo 3 caracteres",
            maxlength:"Máximo 100 caracteres"
        }
    }
});
</script>

@endsection
