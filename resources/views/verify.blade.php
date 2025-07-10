

@extends('layouts.appLogin')
@section('content')


<style>


.auth-container {
    background-color: rgba(255, 255, 255, 0.42);
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    margin: 50px auto;
    animation: fadeInContainer 0.8s ease;
}

@keyframes fadeInContainer {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-title {
    text-align: center;
    color: #fff;
    font-size: 1.8em;
    margin-bottom: 25px;
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.form-group {
    width: 100%;
    max-width: 400px;
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    color: black;
    font-weight: bold;
}

input,
textarea {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    transition: box-shadow 0.3s ease, border-color 0.3s ease;
    box-sizing: border-box;
    width: 100%;
}

input:focus,
textarea:focus {
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
    border-color: #007bff;
}

.btnon {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    max-width: 400px;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btnon:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
}

.alert-danger {
    animation: slideDown 0.5s ease forwards;
    max-width: 400px;
    margin: auto;
    background-color: #dc3545;
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

\.toggle-form {
    text-align: center;
    margin-top: 15px;
    color: black;
}

.toggle-form a {
    color: #007bff;
    font-weight: bold;
    text-decoration: none;
}

.toggle-form a:hover {
    text-decoration: underline;
}

</style>

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
        <button type="submit" class="btnon">Verificar</button>
    </form>
</div>

@endsection
