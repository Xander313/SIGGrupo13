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
        .leyenda { font-size: 11px; margin-top: 5px; color: #555; }
    </style>
</head>
<body>

    <h2>Reporte de Zonas Seguras</h2>
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

    @php
        $emojis = [
            'Refugio' => '<span style="display:inline-block; width:12px; height:12px; background-color:#28a745; border-radius:50%; margin-right:5px;"></span> Refugio (verde)',
            'Centro de salud' => '<span style="display:inline-block; width:12px; height:12px; background-color:#17a2b8; border-radius:50%; margin-right:5px;"></span> Centro de salud (azul)',
            'Zona de evacuación' => '<span style="display:inline-block; width:12px; height:12px; background-color:#dc3545; border-radius:50%; margin-right:5px;"></span> Zona de evacuación (rojo)'
        ];
    @endphp


    @if($tipoSeleccionado && $tipoSeleccionado !== 'Todos')
        <p style="text-align:center; font-size:13px; margin-bottom:10px;">
            <strong>🔎 Zona filtrada:</strong> {!! $emojis[$tipoSeleccionado] ?? $tipoSeleccionado !!}
        </p>
    @else
        <p style="text-align:center; font-size:13px; margin-bottom:10px;">
            <strong>🔎 Mostrando todas las zonas:</strong>
            @foreach($emojis as $texto)
                {!! $texto !!}@if (!$loop->last), @endif
            @endforeach
        </p>
    @endif


    @if($imagenMapa)
        <p><strong>Mapa general de zonas:</strong><p class="leyenda"><em>Este mapa se ha creado con la versión gratuita de Google Maps API JS, por tanto, no se renderizará el mapa.</em></p></p>
        <img src="{{ $imagenMapa }}" style="width:100%; border:1px solid #ccc;" />
        <p class="leyenda">Cada círculo representa una zona de seguridad con su radio de cobertura aproximado.</p>
    @endif

    <h4>Listado de Zonas Seguras</h4>

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
            @forelse($zonas as $zona)
                <tr>
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->nombre }}</td>
                    <td>{{ $zona->tipo_seguridad }}</td>
                    <td>{{ $zona->radio }}</td>
                    <td>{{ $zona->latitud }}</td>
                    <td>{{ $zona->longitud }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No se encontraron zonas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
