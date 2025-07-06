
<div class="auth-container">
    <h2 class="form-title">Registro de Usuario</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('registro') }}">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea id="direccion" name="direccion"></textarea>
        </div>

        <div class="form-group">
            <label for="contraseña">Contraseña</label>
            <input type="password" id="contraseña" name="contraseña" required>
        </div>

        <button type="submit" class="btn">Registrarse</button>
    </form>

    <div class="toggle-form mt-2">
        ¿Ya tienes cuenta? <a href="{{ route('loginIn') }}">Inicia sesión aquí</a>
    </div>
</div>

