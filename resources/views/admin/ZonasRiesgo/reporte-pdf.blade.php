<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Zonas de Riesgo</title>
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

    <h2>Reporte de Zonas de Riesgo</h2>

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
        $colores = [
            'Alto' => '<span style="display:inline-block; width:12px; height:12px; background-color:#dc3545; border-radius:50%; margin-right:5px;"></span> Riesgo Alto (rojo)',
            'Medio' => '<span style="display:inline-block; width:12px; height:12px; background-color:#fd7e14; border-radius:50%; margin-right:5px;"></span> Riesgo Medio (naranja)',
            'Bajo' => '<span style="display:inline-block; width:12px; height:12px; background-color:#ffc107; border-radius:50%; margin-right:5px;"></span> Riesgo Bajo (amarillo)'
        ];
    @endphp

    @if($nivelSeleccionado && $nivelSeleccionado !== 'Todos')
        <p style="text-align:center; font-size:13px; margin-bottom:10px;">
            <strong>🔎 Nivel filtrado:</strong> {!! $colores[$nivelSeleccionado] ?? $nivelSeleccionado !!}
        </p>
    @else
        <p style="text-align:center; font-size:13px; margin-bottom:10px;">
            <strong>🔎 Mostrando todos los niveles:</strong>
            @foreach($colores as $texto)
                {!! $texto !!}@if (!$loop->last), @endif
            @endforeach
        </p>
    @endif


    @if($imagenMapa)
        <p><strong>Mapa general de zonas de riesgo:</strong></p>
        <p class="leyenda">
            <em>Este mapa ha sido generado usando Google Maps. Por limitaciones del servicio, el mapa puede no mostrarse en esta vista.</em>
        </p>
        <img src="{{ $imagenMapa }}" style="width:100%; border:1px solid #ccc;" />
        <p class="leyenda">Cada polígono representa una zona de riesgo definida por cuatro coordenadas geográficas.</p>
    @endif

    <h4>Listado de Zonas de Riesgo</h4>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Nivel de riesgo</th>
                <th>Coordenada 1</th>
                <th>Coordenada 2</th>
                <th>Coordenada 3</th>
                <th>Coordenada 4</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riesgos as $riesgo)
                <tr>
                    <td>{{ $riesgo->nombre }}</td>
                    <td>{{ $riesgo->descripcion }}</td>
                    <td>{{ $riesgo->nivel }}</td>
                    <td>
                        Lat: {{ $riesgo->latitud1 }}<br>
                        Lon: {{ $riesgo->longitud1 }}
                    </td>
                    <td>
                        Lat: {{ $riesgo->latitud2 }}<br>
                        Lon: {{ $riesgo->longitud2 }}
                    </td>
                    <td>
                        Lat: {{ $riesgo->latitud3 }}<br>
                        Lon: {{ $riesgo->longitud3 }}
                    </td>
                    <td>
                        Lat: {{ $riesgo->latitud4 }}<br>
                        Lon: {{ $riesgo->longitud4 }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No se encontraron zonas de riesgo registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
