@extends('layouts.appAdmin')

@section('content')

<br>
<h1 class="text-center">Listado de Provincias</h1>

<div class="container mt-5">
    <div class="mx-auto" style="max-width: 1500px;">

        <a href="{{ route('provinces.create') }}" class="btn btn-success mb-4">
            <i class="fas fa-plus-circle"></i> Registrar nueva Provincia
        </a>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="provinces-table">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Capital</th>
                        <th>Población</th>
                        <th>Clima Predominante</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($provinces as $province)
                    <tr>
                        <td>{{ $province->NombreProvincia }}</td>
                        <td>{{ $province->Capital }}</td>
                        <td>{{ number_format($province->Poblacion) }}</td>
                        <td>{{ $province->ClimaPredominante }}</td>

                        <td class="text-center">

                            <a href="{{ route('provinces.edit', $province->IdProvincia) }}"
                               class="btn btn-sm btn-primary d-block mb-2">
                                Editar
                            </a>

                            <form action="{{ route('provinces.destroy', $province->IdProvincia) }}"
                                  method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger btn-eliminar d-block">
                                    Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay provincias registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- CONFIRMACIÓN SWEETALERT PARA ELIMINAR --}}
<script>
$(document).ready(function() {
    $('.btn-eliminar').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: '¿Eliminar esta provincia?',
            text: "Esta acción no puede deshacerse.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>

{{-- DATATABLE --}}
<script>
$(document).ready(function() {
    new DataTable('#provinces-table', {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
        },
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>

@endsection
