<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Zonas Seguras</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        h2 { text-align: center; margin-bottom: 20px; }
        img { margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 12px; text-align: center; }
        .qr { float: right; margin-top: -80px; }
    </style>
</head>
<body>

    <h2>Reporte de Zonas Seguras</h2>

    @if($mapBase64)
        <p><strong>Mapa general de zonas:</strong></p>
        <img src="{{ $mapBase64 }}" style="width:100%; border:1px solid #ccc;" />
    @endif

    @if($qrBase64)
        <div class="qr">
            <p style="font-size: 11px;"><strong>QR del Reporte:</strong></p>
            <img src="{{ $qrBase64 }}" width="100" alt="QR" />
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Radio (m)</th>
                <th>Latitud</th>
                <th>Longitud</th>
            </tr>
        </thead>
        <tbody>
            @foreach($zonas as $zona)
                <tr>
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->nombre }}</td>
                    <td>{{ $zona->tipo_seguridad }}</td>
                    <td>{{ $zona->radio }}</td>
                    <td>{{ $zona->latitud }}</td>
                    <td>{{ $zona->longitud }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
