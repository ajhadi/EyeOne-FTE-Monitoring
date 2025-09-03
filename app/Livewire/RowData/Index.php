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
        // Get today's date
        $today = Carbon::today();
        // Get week start (Monday)
        $startDate = $today->copy()->startOfWeek(Carbon::MONDAY);
        // Get week end (Sunday)
        $endDate = $today->copy()->endOfWeek(Carbon::SUNDAY);
        // Total projects with updates this week
        $this->totalUpdate = Project::whereHas('projectUpdates', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]);
        })->count();

        // Total projects without updates this week
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
