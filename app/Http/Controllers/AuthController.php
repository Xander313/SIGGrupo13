<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;




class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function verifyEmail(Request $request)
    {
        $inputCode = $request->input('verification_code');
        $storedCode = Session::get('verification_code');

        if ($inputCode !== (string)$storedCode) {
            return redirect()->route('verify_email')->withErrors(['codigo' => 'Código incorrecto']);
        }

        $email = Session::get('email');

        if (!Usuario::where('email', $email)->exists()) {
            Usuario::create([
                'nombre' => Session::get('nombre'),
                'email' => $email,
                'contraseña' => Hash::make(Session::get('contraseña')),
                'telefono' => Session::get('telefono'),
                'direccion' => Session::get('direccion'),
            ]);
            Session::forget(['verification_code', 'email', 'contraseña', 'nombre', 'telefono', 'direccion']);
            return view('login')->with('success', 'Registro exitoso. Puedes iniciar sesión.');
        } else {
            return redirect()->route('loginIn')->with('info', 'El usuario ya existe. Inicia sesión.');
        }
    }



    public function iniciarSesion (Request $request)
    {
        return view('login'); 

    }



public function sesionInicada(Request $request)
{
    // Validar los datos del formulario
    $credentials = $request->validate([
        'correoUsuario' => 'required|email',
        'passwordUsuario' => 'required|string',
    ]);

        if (
            $credentials['correoUsuario'] === 'mainadmin@main.com' &&
            Hash::check($credentials['passwordUsuario'], '$2y$12$haiANH3hj2MA6jggIE3C8ubBdl.47jJ83U/UGk6CVPIgRTP14FAP6')
        ) {
            // ✅ Redirigir a la vista personalizada del admin
            return redirect()->route('zonas-seguras.index')->with('success', 'Bienvenido, administrador');
        }

    // Buscar al usuario por email
    $usuario = Usuario::where('email', $credentials['correoUsuario'])->first();

    // Verificar si el usuario existe y la contraseña coincide
    if ($usuario && Hash::check($credentials['passwordUsuario'], $usuario->contraseña)) {

        // Guardar manualmente los datos del usuario en la sesión
        $request->session()->put('usuario_autenticado', true);
        $request->session()->put('usuario_id', $usuario->id);
        $request->session()->put('usuario_nombre', $usuario->nombre);

        // 🔒 Verificar si es el admin principal

        // Si no es el admin especial, ir a inicio general
        return redirect()->route('user.inicio');
    }

    // Si la autenticación falla
    return back()->withErrors([
        'correoUsuario' => 'Las credenciales no coinciden con nuestros registros.',
    ])->onlyInput('correoUsuario');
}




    public function showRegistro()
    {
        return view('registro'); 
    }




    public function registro(Request $request)
    {
        // 1. Validar entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|ends_with:@gmail.com',
            'contraseña' => 'required|min:6',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // 2. Generar código aleatorio
        $codigo = random_int(100000, 999999);

        // 3. Guardar en session (sin hash aún)
        session([
            'registro_datos' => [
                'nombre' => $request->nombre,
                'email' => $request->email,
                'contraseña' => $request->contraseña,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ],
            'codigo_verificacion' => $codigo,
        ]);

        Mail::send('emails.codigo_verificacion', [
            'nombre' => $request->nombre,
            'codigo' => $codigo,
        ], function ($msg) use ($request) {
            $msg->to($request->email)
                ->subject('Tu código de verificación');
        });


        return redirect()->route('verify_email')->with('success', 'Código enviado a tu correo.');
    }



   public function verificarCodigo(Request $request)
    {
        $request->validate(['codigo' => 'required|digits:6']);

        if ($request->codigo != Session::get('codigo_verificacion')) {
            return back()->withErrors(['codigo' => 'El código es incorrecto'])->withInput();
        }

        $datos = Session::get('registro_datos');

        if (Usuario::where('email', $datos['email'])->exists()) {
            return redirect()->route('loginIn')->with('info', 'Ya existe un usuario con ese correo.');
        }

        Usuario::create([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'contraseña' => Hash::make($datos['contraseña']),
            'telefono' => $datos['telefono'],
            'direccion' => $datos['direccion'],
        ]);

        Session::forget(['registro_datos', 'codigo_verificacion']);

        return view('login')->with('success', '¡Registro exitoso! Ahora inicia sesión.');


    }





    public function mostrarVerificacion()
    {
        return view('verify');
    }



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
