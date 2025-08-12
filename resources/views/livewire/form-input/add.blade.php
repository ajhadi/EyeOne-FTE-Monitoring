<?php

use App\Models\Project;
use App\Models\Vendor;
use App\Models\ProjectUpdate;
use Livewire\Volt\Component;
use Masmerise\Toaster\Toaster;

new class extends Component {
    public $date;
    public $vendor_id;
    public $project_id;
    public $job_status;
    public $problem_status;
    public $problem_details;
    public $estimated_pull;
    public $estimated_tracing;
    public $actual_pull;
    public $actual_tracing;


    public string $errorTitle = '';
    public array $errorMessages = [];
    public $vendors = [];
    public $projects = [];

    public function mount(): void
    {
        $this->vendors = Vendor::select('id', 'code')->get();
        $this->projects = collect(); // kosong
    }

    public function updatedVendorId($value): void
    {
        $this->projects = Project::where('vendor_id', $value)
            ->select('id', 'pa_number')
            ->get();



        // reset project_id jika vendor berubah
//        $this->project_id = null;
    }

    public function updatedProjectId($value): void
    {
        // Ambil ProjectUpdate terbaru berdasarkan 'date' (urut descending, ambil 1)
        $latestUpdate = ProjectUpdate::where('project_id', $value)
            ->latest()
            ->first();

        if ($latestUpdate) {
            $this->estimated_pull = $latestUpdate->estimated_pull - $latestUpdate->actual_pull;
            $this->estimated_tracing = $latestUpdate->estimated_tracing - $latestUpdate->actual_tracing;
        } else {
            // Jika tidak ada data, set 0 atau null sesuai kebutuhan
            $this->estimated_pull = 0;
            $this->estimated_tracing = 0;
        }

        $project = Project::find($value);

        $this->job_status = $project->type;
    }


    public function addProjectUpdate(): void
    {
        $this->errorTitle = '';
        $this->errorMessages = [];

        $validated = $this->validate([
            'date' => ['required', 'date'],
            'vendor_id' => ['required'],
            'project_id' => ['required'],
            'job_status' => ['required', 'string'],
            'problem_status' => ['required', 'string'],
            'problem_details' => ['nullable', 'string'],
            'estimated_pull' => ['nullable'],
            'actual_pull' => ['nullable'],
            'estimated_tracing' => ['nullable'],
            'actual_tracing' => ['nullable'],
        ]);

        $project = Project::find($value);

        $validated['job_status'] = $project->type;

        $exists = ProjectUpdate::where('vendor_id', $validated['vendor_id'])
            ->where('project_id', $validated['project_id'])
            ->exists();

        if ($exists) {
            // Jika sudah ada, set estimated_pull dan estimated_tracing jadi 0
            $validated['estimated_pull'] = 0;
            $validated['estimated_tracing'] = 0;
        }

        ProjectUpdate::create($validated);


        $this->dispatch('refreshProjectUpdateTable');

        // Reset input fields
        $this->resetForm();

        Toaster::success('Data created!'); // 👈
    }

    public function resetForm()
    {
        $this->reset([
            'date',
            'vendor_id',
            'project_id',
            'job_status',
            'problem_status',
            'problem_details',
            'estimated_pull',
            'estimated_tracing',
            'actual_pull',
            'actual_tracing'
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
                <flux:heading size="lg">Data Form Input</flux:heading>
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


            <flux:input type="date" label="Tanggal Input" wire:model.defer="date"/>

            <flux:select label="Vendor" wire:model.live="vendor_id">
                <flux:select.option value="">-- Pilih --</flux:select.option>
                @foreach($vendors as $vendor)
                    <flux:select.option value="{{ $vendor->id }}">
                        {{ $vendor->code }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select label="No. Project Aktivasi" wire:model.live="project_id" :disabled="!$vendor_id">
                <flux:select.option value="">-- Pilih --</flux:select.option>
                @foreach($projects as $project)
                    <flux:select.option value="{{ $project->id }}">
                        {{ $project->pa_number }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select label="Status Pekerjaan" wire:model.defer="job_status">
                <flux:select.option value="">-- Pilih --</flux:select.option>
                @foreach(App\Enums\StatusPekerjaan::toSelectOptions() as $option)
                    <flux:select.option value="{{ $option['value'] }}">
                        {{ ucwords($option['label']) }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select label="Problem Status" wire:model.defer="problem_status">
                <flux:select.option value="">-- Pilih --</flux:select.option>
                @foreach(App\Enums\TipeKendala::toSelectOptions() as $option)
                    <flux:select.option value="{{ $option['value'] }}">
                        {{ $option['label'] }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:textarea style="resize:none" label="Detail Kendala" placeholder="Detail Kendala"
                           wire:model.defer="problem_details"/>

            <flux:input label="Estimasi Tarikan" placeholder="Estimasi Tarikan" wire:model.defer="estimated_pull"/>

            <flux:input label="Estimasi Tracing" placeholder="Estimasi Tracing" wire:model.defer="estimated_tracing"/>

            <flux:input label="Realisasi Tarikan" placeholder="Realisasi Tarikan" wire:model.defer="actual_pull"/>

            <flux:input label="Realisasi Tracing" placeholder="Realisasi Tracing" wire:model.defer="actual_tracing"/>

            <div class="flex">
                <flux:spacer/>
                <flux:button wire:click="addProjectUpdate" variant="primary">Simpan</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

