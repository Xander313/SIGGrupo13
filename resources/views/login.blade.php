
@extends('layouts.appLogin')
@section('content')


<style>

.auth-container {
    background-color: rgba(255, 255, 255, 0.42);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    margin: auto;
}

.form-title {
    color: #fff; 
    text-shadow: 0 0 5px rgba(0,0,0,0.2); 
}

input[type="email"],
input[type="password"] {
    transition: box-shadow 0.3s ease;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 4px;
}

input[type="email"]:focus,
input[type="password"]:focus {
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
    border-color: #007bff;
}



.btnon:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
}
.form-group {
    position: relative;
}
form {
    display: flex;
    flex-direction: column;
    gap: 20px; 
    align-items: center;
}

.form-group {
    width: 100%;
    max-width: 400px;
    position: relative;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    box-sizing: border-box;
}

.btnon {
    display: block;
    width: 100%;
    max-width: 400px;
    padding: 12px;
    font-size: 1em;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
    border-color: #007bff;
    background-color: #007bff;
}

.form-title {
    text-align: center;
    margin-bottom: 20px;
}

.welcome-text p {
    text-align: center;
    font-size: 1.1em;
    color: #555;
    margin-bottom: 15px;
    animation: fadeIn 1s ease;
    color: black;
    
}

label{
    color: black;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert-danger {
    animation: slideDown 0.5s ease forwards;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}



</style>


<div class="welcome-text">
    <p>👋 ¡Bienvenido de nuevo! Inicia sesión para continuar.</p>
</div>


<div class="auth-container welcome-text">
    <h2 class="form-title">Iniciar Sesión</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('loginIn') }}">
        @csrf
        <div class="form-group">
            <label for="correoUsuario">Correo Electrónico</label>
            <input type="email" id="correoUsuario" name="correoUsuario" required>
            <i class="fas fa-envelope"></i>
        </div>

        <div class="form-group">
            <label for="passwordUsuario">Contraseña</label>
            <input type="password" id="passwordUsuario" name="passwordUsuario" required>
            <i class="fas fa-lock"></i>
        </div>

        <button type="submit" class="btnon">Ingresar</button>
    </form>

    <div class="toggle-form mt-2">
        <p>¿No tienes cuenta?</p> <a href="{{ route('registro_form') }}">Regístrate aquí</a>
    </div>
</div>


@endsection