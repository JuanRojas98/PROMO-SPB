<?php

namespace App\Livewire\Backoffice\Invoices;

use App\Models\Invoice;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvoiceValidate extends Component
{
    public $invoice_id;
    public $invoice_status;

    public $observations = '', $points = 0;

    protected $listeners = [
        'approve-invoice' => 'approve',
        'reject-invoice' => 'reject'
    ];

    protected $rules = [
        'points' => 'required_if:invoice_status,approved|numeric',
        'observations' => 'required_if:invoice_status,rejected|string',
    ];

    protected $messages = [
        'points.required_if' => 'Ingrese los puntos.',
        'observations.required_if' => 'Ingrese las observaciones.',
    ];

    public function render() {
        return view('livewire.backoffice.invoices.invoice-validate');
    }

    public function approve($id) {
        $this->resetFields();
        $this->invoice_id = $id;
        $this->invoice_status = 'approved';
        $this->dispatch('open-modal', name: 'invoice-validate');
    }

    public function reject($id) {
        $this->resetFields();
        $this->invoice_id = $id;
        $this->invoice_status = 'rejected';
        $this->dispatch('open-modal', name: 'invoice-validate');
    }

    public function save() {
        $invoice = Invoice::where([
            'id' => $this->invoice_id,
            'status' => 'pending'
        ])->first();

        if (! $invoice) {
            return false;
        }

        $invoice->update([
            'status' => $this->invoice_status,
            'observations' => $this->observations,
            'points' => $this->points,
            'validated_by' => Auth::user()->id,
            'validated_at' => now()
        ]);

        if ($this->invoice_status === 'approved') {
            $invoice_score = Score::where(['invoice_id' => $this->invoice_id])->first();
            $invoice_score->update([
                'points' => $invoice_score->points + $this->points,
            ]);
        }

        $this->dispatch('invoice-saved');
        $this->dispatch('close-modal', name: 'invoice-validate');
        $this->resetFields();
    }

    private function resetFields() {
        $this->reset([
            'invoice_id',
            'invoice_status',
            'observations',
            'points'
        ]);
    }
}
