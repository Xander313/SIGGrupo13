<h2 style="text-align:center;">Reporte de Zonas Seguras</h2>

@if($imagenMapa)
    <p><strong>Mapa capturado:</strong></p>
    <img src="{{ $imagenMapa }}" style="width:100%; border:1px solid #ccc;" />
@endif

<img src="data:image/png;base64,{{ $qrBase64 }}" width="100" alt="QR" />

<table style="width:100%; border-collapse: collapse;" border="1">
    <thead>
        <tr><th>ID</th><th>Nombre</th><th>Tipo</th><th>Radio</th><th>Coordenadas</th></tr>
    </thead>
    <tbody>
        @foreach($zonas as $zona)
        <tr>
            <td>{{ $zona->id }}</td>
            <td>{{ $zona->nombre }}</td>
            <td>{{ $zona->tipo_seguridad }}</td>
            <td>{{ $zona->radio }}</td>
            <td>{{ $zona->latitud }}, {{ $zona->longitud }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
