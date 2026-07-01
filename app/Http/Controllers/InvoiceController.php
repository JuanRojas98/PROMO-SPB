<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    public function export($status = null) {
        return Excel::download(new InvoicesExport($status), 'reporte-facturas.xlsx');
    }
}
