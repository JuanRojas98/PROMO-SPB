<?php

namespace App\Livewire\Backoffice\Invoices;

use App\Models\City;
use App\Models\Department;
use App\Models\Invoice;
use App\Traits\Email;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    use Email;

    public $cities = [];
    public $departments = [];
    public $invoices = [];

    public $document, $department_id, $city_id;

    public $showRejectModal = false;
    public $invoice_id_to_reject = null;
    public $observations = '';

    public function render()
    {
        $queryInvoices = Invoice::query()
            ->with([
                'user',
                'user.city'
            ])
            ->where('status', 'pending')
            ->when($this->document, function ($query) {
                $query->whereHas('user', function ($queryUser) {
                    $queryUser->where('document', 'LIKE', '%' . $this->document . '%');
                });
            })
            ->when($this->department_id, function ($query) {
                $query->whereHas('user.city', function ($queryCity) {
                    $queryCity->where(
                        'department_id',
                        $this->department_id
                    );
                });
            })
            ->when($this->city_id, function ($query) {
                $query->whereHas('user', function ($queryUser) {
                    $queryUser->where('city_id', $this->city_id);
                });
            });

        $this->invoices = $queryInvoices->latest()->get();

        return view('livewire.backoffice.invoices.index')
            ->layout('layouts.app');
    }

    public function mount() {
        $this->getDepartments();
    }

    public function getDepartments() {
        $this->departments = Department::where('active', 1)->get();
    }

    public function updatedDepartmentId($value) {
        if ($value != '') {
            $this->cities = City::where([
                'department_id' => $value,
                'active' => 1
            ])->get();
        }
        else {
            $this->cities = [];
        }
    }

    public function openRejectModal($invoice_id) {
        $this->invoice_id_to_reject = $invoice_id;
        $this->observation = '';
        $this->showRejectModal = true;
    }

    public function approve($id) {
        $invoice = $this->updateInvoiceStatus($id, 'approved');

        if (!$invoice) {
            return $this->dispatch(
                'invoice-approved',
                message: 'La factura ya fue gestionada.'
            );
        }

        $this->dispatch(
            'invoice-approved',
            message: 'Factura aprobada correctamente.'
        );
    }

    public function reject() {
        $this->validate(
            ['observations' => 'required|min:10'],
            [
                'observation.required' => 'La observación es obligatoria.',
                'observation.min' => 'La observación debe tener al menos 10 caracteres.',
            ]
        );

        $invoice = $this->updateInvoiceStatus($this->invoice_id_to_reject, 'rejected', $this->observations);

        $this->showRejectModal = false;
        $this->invoice_id_to_reject = null;
        $this->observation = '';

        if (!$invoice) {
            return $this->dispatch(
                'invoice-rejected',
                message: 'La factura ya fue gestionada.'
            );
        }

        $this->sendEmail(
            $invoice->user->email,
            'Factura rechadaza',
            'emails.invoice-reject',
            [
                'user' => $invoice->user,
                'invoice' => $invoice
            ]
        );

        $this->dispatch(
            'invoice-rejected',
            message: 'Factura rechazada correctamente.'
        );
    }

    public function updateInvoiceStatus($id, $status, $observations = null) {
        $invoice = Invoice::where([
            'id' => $id,
            'status' => 'pending'
        ])->first();

        if (! $invoice) {
            return false;
        }

        return $invoice->update([
            'status' => $status,
            'observations' => $observations,
            'validated_by' => Auth::user()->id,
            'validated_at' => now()
        ]);
    }
}
