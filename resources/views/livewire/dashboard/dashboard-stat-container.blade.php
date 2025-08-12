<?php
use function Livewire\Volt\{state, mount};
use App\Models\Vendor;
use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Enums\StatusPekerjaan;

state([
    'total_vendor' => 0,
    'total_active_project' => 0,
    'total_problem' => 0,
]);

mount(function () {
    $this->total_vendor = Vendor::count();
    $this->total_active_project = Project::whereNot('type', StatusPekerjaan::CLOSED->value)->count();
    $this->total_problem = ProjectUpdate::count();
});
?>
<div class="relative items-end overflow-hidden rounded-xl border bg-white border-neutral-200 dark:border-neutral-700 p-5">
    <div class="grid gap-4 md:grid-cols-4">
        <x-dashboard-stat-card icon="users" title="Total Company" :count="$total_vendor" subtitle="mitra" />
        <x-dashboard-stat-card icon="timer" title="Active Project" :count="$total_active_project" subtitle="active" />
        <x-dashboard-stat-card icon="timer-off" title="Impediment" :count="$total_problem" subtitle="issued" />


        <!-- Data ABK -->
        <a href="{{ route('data-abk') }}">
            <div
                class="flex flex-col justify-center  items-center bg-zinc-200 dark:border-zinc-700 dark:bg-zinc-900 rounded-xl px-4 py-6 shadow">
                <div class="text-3xl font-bold text-gray-900">
                    <flux:icon.database/>
                </div>
                <div class="mt-2 w-full flex items-center justify-center">
                    <div class="text-sm text-gray-700 font-bold">Data ABK</div>
                </div>
            </div>
        </a>
    </div>
</div>
