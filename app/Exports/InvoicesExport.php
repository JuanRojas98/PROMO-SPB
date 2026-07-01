<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoicesExport implements FromView, WithColumnWidths, WithStyles
{
    protected $invoices = [];

    public function __construct($state = null) {
        $queryInvoices = Invoice::query()
            ->with([
                'user',
                'user.city'
            ])
            ->when($state, function ($query) use ($state) {
                $query->where('status', $state);
            });

        $this->invoices = $queryInvoices->latest()->get();
    }

    public function view(): View {
        return view('exports.invoice-report', [
            'invoices' => $this->invoices
        ]);
    }

    public function columnWidths(): array {
        return [
            'A' => 8,
            'B' => 16,
            'C' => 16,
            'D' => 16,
            'E' => 16,
            'F' => 16,
            'G' => 16,
            'H' => 16
        ];
    }

    public function styles(Worksheet $sheet) {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]]
        ];
    }
}
