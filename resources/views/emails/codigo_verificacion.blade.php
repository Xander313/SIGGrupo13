<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de correo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            background: white;
            width: 90%;
            max-width: 480px;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h2 {
            color: #3b82f6;
            text-align: center;
        }
        p {
            color: #333;
            font-size: 16px;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            color: #2563eb;
            text-align: center;
            margin: 20px 0;
            letter-spacing: 4px;
        }
        .footer {
            font-size: 12px;
            color: #888;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verificación de Correo</h2>
        <p>Hola {{ $nombre }},</p>
        <p>Gracias por registrarte. Tu código de verificación es:</p>
        <div class="code">{{ $codigo }}</div>
        <p>Ingresa este código para activar tu cuenta.</p>
        <p class="footer">Si no solicitaste este registro, puedes ignorar este mensaje.</p>
    </div>
</body>
</html>
