<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Puntos de Encuentro</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        h2 { text-align: center; margin-bottom: 20px; }
        img { margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 12px; text-align: center; }
        .qr { float: right; margin-top: -80px; }
        .leyenda { font-size: 11px; margin-top: 5px; color: #555; }
    </style>
</head>
<body>

    <h2>Reporte de Puntos de Encuentro</h2>
    @php
        \Carbon\Carbon::setLocale('es');
    @endphp
    <p style="text-align: center; font-size: 12px; margin-bottom: 20px;">
        Generado el {{ \Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e Y') }}
    </p>
    
    @if($qrBase64)
        <div class="qr">
            <p style="font-size: 11px;"><strong>Código QR para Reporte:</strong></p>
            <img src="{{ $qrBase64 }}" width="100" alt="QR" />
        </div>
    @endif

    @if($imagenMapa)
        <p><strong>Mapa general de puntos de encuentro:</strong></p>
        <img src="{{ $imagenMapa }}" style="width:100%; border:1px solid #ccc;" />
        <p class="leyenda">Cada círculo representa un punto de encuentro con su radio de cobertura.</p>
    @endif

    <h4>Listado de Puntos de Encuentro</h4>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>Responsable</th>
                <th>Radio (m)</th>
                <th>Ubicación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($puntos as $punto)
                <tr>
                    <td>{{ $punto->id }}</td>
                    <td>{{ $punto->nombre }}</td>
                    <td>{{ $punto->capacidad }} personas</td>
                    <td>{{ $punto->responsable }}</td>
                    <td>{{ $punto->radio }}</td>
                    <td>
                        Lat: {{ $punto->latitud }}<br>
                        Lng: {{ $punto->longitud }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No se encontraron puntos de encuentro registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>