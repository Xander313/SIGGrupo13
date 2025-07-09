
@extends('layouts.appLogin')
@section('content')


<div class="auth-container">
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

        <button type="submit" class="btn">Ingresar</button>
    </form>

    <div class="toggle-form mt-2">
        <p>¿No tienes cuenta?</p> <a href="{{ route('registro_form') }}">Regístrate aquí</a>
    </div>
</div>


@endsection