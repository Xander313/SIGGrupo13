@extends('layout.app')

@section('contenido')
<div class="container">
    <h1 class="mb-4">Detalles del Punto de Encuentro</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Información Básica</h5>
                    <p><strong>Nombre:</strong> {{ $punto->nombre }}</p>
                    <p><strong>Capacidad:</strong> {{ $punto->capacidad }} personas</p>
                    <p><strong>Responsable:</strong> {{ $punto->responsable }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Ubicación</h5>
                    <p><strong>Latitud:</strong> {{ $punto->latitud }}</p>
                    <p><strong>Longitud:</strong> {{ $punto->longitud }}</p>
                </div>
            </div>
            
            <div class="mt-4">
                <div id="mapa" style="height: 400px; width: 100%; border: 2px solid #ddd;"></div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('puntos-encuentro.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<script>
    function initMap() {
        var ubicacion = { lat: {{ $punto->latitud }}, lng: {{ $punto->longitud }} };
        
        var mapa = new google.maps.Map(document.getElementById('mapa'), {
            center: ubicacion,
            zoom: 15
        });

        new google.maps.Marker({
            position: ubicacion,
            map: mapa,
            title: "{{ $punto->nombre }}"
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap"></script>
@endsection