@extends('layouts.appAdmin')

@section('content')

<h1 class="text-center">Registrar Nueva Provincia</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
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

                <form action="{{ route('provinces.store') }}" id="frm_province" method="POST">
                    @csrf

                    {{-- Nombre de la provincia --}}
                    <label><b>Nombre de la Provincia:</b></label>
                    <input type="text" name="NombreProvincia" 
                           class="form-control" required
                           placeholder="Ej: Pichincha">
                    <br>

                    {{-- Capital --}}
                    <label><b>Capital:</b></label>
                    <input type="text" name="Capital" 
                           class="form-control" required
                           placeholder="Ej: Quito">
                    <br>

                    {{-- Población --}}
                    <label><b>Población:</b></label>
                    <input type="number" name="Poblacion" 
                           class="form-control" min="1" required
                           placeholder="Ej: 2890000">
                    <br>

                    {{-- Clima Predominante --}}
                    <label><b>Clima Predominante:</b></label>
                    <input type="text" name="ClimaPredominante" 
                           class="form-control" required
                           placeholder="Ej: Templado, Frío, Lluvioso">
                    <br>

                    <center>
                        <button class="btn btn-success">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="{{ route('provinces.index') }}" class="btn btn-secondary">Cancelar</a>
                        &nbsp;&nbsp;
                        <button type="reset" class="btn btn-danger">Limpiar</button>
                    </center>

                </form>

            </div>

        </div>
    </div>
</div>

{{-- VALIDACIÓN JQUERY --}}
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
