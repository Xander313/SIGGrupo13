

@extends('layouts.appLogin')
@section('content')


<div class="auth-container">
    <h2 class="form-title">Verificación de Correo</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @error('codigo')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('verify_email_post') }}">
        @csrf
        <label for="codigo">Código de Verificación</label>
        <input type="text" name="codigo" id="codigo" required>
        <button type="submit" class="btn">Verificar</button>
    </form>
</div>

@endsection
