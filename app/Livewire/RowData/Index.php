<?php

namespace App\Livewire\RowData;

use App\Models\Project;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public int $days;
    public int $weeks;
    public int $totalUpdate;
    public int $totalNotUpdate;
    public int $totalProjects;
    public int $average;
    public int $weeksInYear;

    public function mount()
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();
        // Ambil awal minggu (Senin)
        $startDate = $today->copy()->startOfWeek(Carbon::MONDAY);
        // Ambil akhir minggu (Minggu)
        $endDate = $today->copy()->endOfWeek(Carbon::SUNDAY);
        // Total project yang ada update di minggu ini
        $this->totalUpdate = Project::whereHas('projectUpdates', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]);
        })->count();

        // Total project yang tidak ada update di minggu ini
        $this->totalNotUpdate = Project::whereDoesntHave('projectUpdates', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]);
        })->count();

        $this->totalProjects = Project::count();
        $this->days = Carbon::now()->dayOfWeekIso;
        $this->weeks = Carbon::now()->weekOfYear;
        $this->weeksInYear = Carbon::now()->weeksInYear;
        if ($this->totalProjects > 0) {
            $this->average = round(($this->totalUpdate / $this->totalProjects) * 100, 2);
        } else {
            $this->average = 0;
        }
    }

    public function render()
    {
        return view('livewire.row-data.index');
    }
}
