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

    public $document, $department_id, $city_id, $state = 'pending';

    protected $listeners = [
        'invoice-saved' => '$refresh',
    ];

    public function render()
    {
        $queryInvoices = Invoice::query()
            ->with([
                'user',
                'user.city'
            ])
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
            })
            ->when($this->state, function ($query) {
                $query->where('status', $this->state);
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

    public function restartProcess($invoice_id) {
        $invoice = Invoice::where([
            'id' => $invoice_id,
        ])->whereIn('status', ['approved', 'rejected'])->first();

        if (! $invoice) {
            $this->dispatch('invoice-reset-fail', message: 'No se encuentra la factura.');
        }

        $invoice->update([
            'status' => 'pending',
            'observations' => null,
            'points' => 0,
            'validated_by' => null,
            'validated_at' => null
        ]);

        $this->dispatch('invoice-saved');
        $this->dispatch('invoice-reset', message: 'Ya puedes volver a gestionar esta factura.');
    }

    public function refresh() {}
}
