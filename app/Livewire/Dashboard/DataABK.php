<?php

namespace App\Livewire\Dashboard;

use App\Enums\StatusPekerjaan;
use App\Models\Project;
use DB;
use Livewire\Component;

class DataABK extends Component
{

    public int $open;
    public int $survey;
    public int $foc;
    public int $tracing;
    public int $jointing;
    public int $fot;
    public int $closed;

    public function mount()
    {
        $counts = Project::query()
            ->select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type') // hasil: ['open' => 10, 'survey' => 5, ...]
            ->toArray();

        // Set default 0 kalau tidak ada datanya
        $this->open     = $counts[StatusPekerjaan::OPEN->value]     ?? 0;
        $this->survey   = $counts[StatusPekerjaan::SURVEY->value]   ?? 0;
        $this->foc      = $counts[StatusPekerjaan::FOC->value]      ?? 0;
        $this->tracing  = $counts[StatusPekerjaan::TRACING->value]  ?? 0;
        $this->jointing = $counts[StatusPekerjaan::JOINTING->value] ?? 0;
        $this->fot      = $counts[StatusPekerjaan::FOT->value]      ?? 0;
        $this->closed   = $counts[StatusPekerjaan::CLOSED->value]   ?? 0;
    }

    public function render()
    {
        return view('livewire.dashboard.data-a-b-k');
    }
}
