@extends('layouts.appUser')
@section('content')


<style>

.welcome-container {
    max-width: 700px;
    margin: auto;
    padding: 40px;
    background-color: rgba(255,255,255,0.42);
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    animation: fadeInContainer 1s ease;
}

.welcome-title {
    text-align: center;
    font-size: 2em;
    color: #fff;
    text-shadow: 0 0 6px rgba(0,0,0,0.3);
    margin-bottom: 20px;
}

.welcome-text {
    font-size: 1.1em;
    text-align: center;
    color: #000;
    margin-bottom: 25px;
}

.access-box {
    background-color: rgba(255,255,255,0.85);
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    color: #333;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
}

</style>

<div class="welcome-container">
    <h1 class="welcome-title">👋 Bienvenido al Sistema de Gestión Comunitaria</h1>
    <p class="welcome-text">
        Este sistema te permite consultar zonas de seguridad, puntos de encuentro comunitarios y zonas de riesgo en tiempo real sobre el mapa. 
        Puedes generar reportes con coordenadas, imágenes y acceso QR. Toda la información está basada en datos geoespaciales administrados por tu comunidad.
    </p>

    <div class="access-box">
        <p>🔍 Usa el menú para explorar el mapa y generar tus reportes PDF.</p>
        <p>📌 Recuerda: solo los administradores pueden modificar la información de las zonas.</p>
    </div>
</div>

@endsection
