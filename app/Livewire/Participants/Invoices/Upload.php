<?php

namespace App\Livewire\Participants\Invoices;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $invoice_code, $invoice_file = null;

    protected $rules = [
        'invoice_code' => 'required',
        'invoice_file' => 'required|mimes:jpg,png,pdf|max:2048'
    ];

    protected $messages = [
        'invoice_code.required' => 'Digita el código de tu factura.',
        'invoice_code.unique' => 'Esta factura ya fue registrada.',
        'invoice_file.required' => 'Debes subir tu factura.',
        'invoice_file.mimes' => 'El archivo debe ser JPG, PNG o PDF.',
    ];

    public function render()
    {
        return view('livewire.participants.invoices.upload')
            ->layout('layouts.guest');
    }

    public function saveInvoice() {
        $this->validate();

        $exists = Invoice::where('invoice_code', $this->invoice_code)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return $this->addError(
                'invoice_code',
                'Esta factura ya fue registrada.'
            );
        }

        $invoice = Invoice::create([
            'invoice_code' => $this->invoice_code,
            'invoice_file' => $this->invoice_file->store('invoices', 'public'),
            'user_id' => Auth::user()->id
        ]);

        $this->resetFields();
        return $this->dispatch(
            'invoice-saved',
            url: route('participants.game', [
                'invoice_id' => $invoice->id
            ])
        );
    }

    public function resetFields() {
        $this->reset([
            'invoice_code',
            'invoice_file'
        ]);
    }
}
