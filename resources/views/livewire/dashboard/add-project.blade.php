<?php

use App\Models\Project;
use App\Models\Vendor;
use App\Models\ProjectUpdate;
use Carbon\Carbon;
use Livewire\Volt\Component;
use Masmerise\Toaster\Toaster;

new class extends Component {
    public $vendor_id;
    public $disposition_date;
    public $target_date;
    public $pa_number;
    public $contract_number;
    public $customer_name;
    public $customer_address;
    public $ptl;
    public $type;


    public string $errorTitle = '';
    public array $errorMessages = [];
    public $vendors = [];

    public function mount(): void
    {
        $this->vendors = Vendor::select('id', 'name')->get();
    }

    public function addProject(): void
    {
        $this->errorTitle = '';
        $this->errorMessages = [];

        $validated = $this->validate([
            'pa_number' => ['required', 'string', 'max:255'],
            'contract_number' => ['required', 'string', 'max:255'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_address' => ['required', 'string'],
            'ptl' => ['required', 'string', 'max:255'],
            'disposition_date' => ['required', 'date'],
            'target_date' => ['required', 'date', 'after_or_equal:disposition_date'],
            'type' => ['required', 'string', 'max:255'],
            'vendor_id' => ['required', 'exists:vendors,id'],
        ]);


        $disposition = Carbon::parse($validated['disposition_date']);
        $target = Carbon::parse($validated['target_date']);

        $validated['duration'] = $target->diffInDays($disposition);
        Project::create($validated);

        $this->dispatch('refreshProjectTable');

        $this->resetForm();

        Toaster::success('Project created!'); // 👈
    }

    public function resetForm(): void
    {
        $this->reset([
            'pa_number',
            'contract_number',
            'customer_name',
            'customer_address',
            'ptl',
            'disposition_date',
            'target_date',
            'type',
            'vendor_id',
        ]);
    }
};
?>


<div xmlns:flux="http://www.w3.org/1999/html">
    <flux:modal.trigger name="add-project-update">
        <flux:button class="w-full" variant="primary" color="zinc">
            <flux:icon.plus/>
            Input
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="add-project-update" class="md:min-w-2xl">
        <div class="space-y-6">
            <div class="py-2">
                <flux:heading size="lg">Tambah Project</flux:heading>
                <flux:text class="mt-2">Isi informasi di bawah ini.</flux:text>
            </div>


            @if(!empty($errorMessages))
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                     role="alert">
                    <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-medium">{{ $errorTitle }}</span>
                        <ul class="mt-1.5 list-disc list-inside">
                            @foreach ($errorMessages as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif


            <flux:select label="Vendor" wire:model.live="vendor_id">
                <flux:select.option value="">-- Pilih --</flux:select.option>
                @foreach($vendors as $vendor)
                    <flux:select.option value="{{ $vendor->id }}">
                        {{ $vendor->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:input type="date" label="Tanggal Disposisi" wire:model.defer="disposition_date"/>
            <flux:input type="date" label="Tanggal Target" wire:model.defer="target_date"/>

            <flux:input label="PA Number" wire:model.defer="pa_number"/>
            <flux:input label="Contract Number" wire:model.defer="contract_number"/>
            <flux:input label="Nama pelanggan" wire:model.defer="customer_name"/>

            <flux:textarea style="resize:none" label="Alamat pelanggan"
                           wire:model.defer="customer_address"/>

            <flux:input label="PTL" wire:model.defer="ptl"/>

            <flux:select label="Tipe Pekerjaan" wire:model.defer="type">
                <flux:select.option value="">-- Pilih --</flux:select.option>
                @foreach(App\Enums\StatusPekerjaan::toSelectOptions() as $option)
                    <flux:select.option value="{{ $option['value'] }}">
                        {{ ucwords($option['label']) }}
                    </flux:select.option>
                @endforeach
            </flux:select>


            <div class="flex">
                <flux:spacer/>
                <flux:button wire:click="addProject" variant="primary">Simpan</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

