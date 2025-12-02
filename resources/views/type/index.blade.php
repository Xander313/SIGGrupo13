@extends('layouts.appAdmin')

@section('content')

<br>
<h1 class="text-center">Listado de Tipos de Atracción</h1>

<div class="container mt-5">
    <div class="mx-auto" style="max-width: 1500px;">

        <a href="{{ route('types.create') }}" class="btn btn-success mb-4">
            <i class="fas fa-plus-circle"></i> Registrar nuevo Tipo de Atracción
        </a>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="types-table">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre del Tipo</th>
                        <th>Nivel de Popularidad</th>
                        <th>Requiere Guía</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($types as $type)
                    <tr>
                        <td>{{ $type->NombreTipoAtraccion }}</td>
                        <td>{{ $type->NivelPopularidad }}</td>
                        <td>{{ $type->RequiereGuia }}</td>

                        <td class="text-center">

                            <a href="{{ route('types.edit', $type->IdTipoAtraccion) }}"
                               class="btn btn-sm btn-primary d-block mb-2">
                                Editar
                            </a>

                            <form action="{{ route('types.destroy', $type->IdTipoAtraccion) }}"
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
                        <td colspan="4" class="text-center">No hay tipos de atracción registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SWEET ALERT PARA CONFIRMACIÓN DE ELIMINAR --}}
<script>
$(document).ready(function() {
    $('.btn-eliminar').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: '¿Eliminar este tipo de atracción?',
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
    new DataTable('#types-table', {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
        },
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>

@endsection
