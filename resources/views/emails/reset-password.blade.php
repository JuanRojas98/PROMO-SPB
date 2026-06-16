@extends('emails.layouts.main')

@section('content')
    <h2 style="margin-top:0;color:#00543D;">
        Recuperación de contraseña
    </h2>

    <p>
        Hola {{ $user->first_name . " " . $user->last_name }},
    </p>

    <p>
        Recibimos una solicitud para restablecer la contraseña de tu cuenta.
    </p>

    <p>
        Haz clic en el siguiente botón para crear una nueva contraseña.
    </p>

    <p>
        Si no realizaste esta solicitud, puedes ignorar este correo.
    </p>
@endsection

@section('button')
    <a href="{{ $url }}"
       style="background:#FDB913; color:#000; text-decoration:none; padding:15px 40px; border-radius:10px; font-weight:bold; display:inline-block;">
        RESTABLECER CONTRASEÑA
    </a>
@endsection
