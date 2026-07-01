<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>USUARIO</th>
            <th>CEDULA</th>
            <th>TELEFONO</th>
            <th>DEPARTAMENTO</th>
            <th>CIUDAD</th>
            <th>CÓDIGO DE FACTURA</th>
            <th>ESTADO</th>
            <th>FECHA REGISTRO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->user->first_name . ' ' . $invoice->user->last_name }}</td>
                <td>{{ $invoice->user->document }}</td>
                <td>{{ $invoice->user->phone }}</td>
                <td>{{ $invoice->user->city->department->name}}</td>
                <td>{{ $invoice->user->city->name }}</td>
                <td>{{ $invoice->invoice_code }}</td>
                <td>
                    @switch ($invoice->status)
                        @case ('approved')
                            {{ 'APROBADO' }}
                            @break
                        @case ('rejected')
                            {{ 'RECHAZADO' }}
                            @break;
                        @default
                            {{ 'PENDIENTE' }}
                            @break;
                    @endswitch
                </td>
                <td>{{ $invoice->created_at->format('d/m/Y h:i A') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
