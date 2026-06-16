@extends('emails.layouts.main')

@section('content')
    <h2 style="margin-top:0;color:#00543D;">
        Factura rechazada
    </h2>

    <p>
        Hola {{ $user->first_name . " " . $user->last_name }},
    </p>

    <p>
        Tu factura no pudo ser validada para participar en la promoción.
    </p>

    <p>
        <strong>Observaciones:</strong> {{ $invoice->observations }}
    </p>

    <p>
        Te invitamos a revisar la información registrada y cargar una nueva factura.
    </p>
@endsection

@section('button')
    <a href="{{ route('participants.invoices.upload') }}"
        style="background:#FDB913; color:#000; text-decoration:none; padding:15px 40px; border-radius:10px; font-weight:bold; display:inline-block;">
        CARGAR FACTURA
    </a>
@endsection
