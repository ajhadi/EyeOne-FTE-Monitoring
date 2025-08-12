<?php

namespace App\Livewire\Dashboard;

use App\Enums\StatusPekerjaan;
use App\Helpers\CalculationHelper;
use App\Models\Vendor;
use Livewire\Component;

class MainDashboard extends Component
{
    public string $vendorNameFilter = '';
    public string $vendorZoneFilter = '';
    public string $monthAnalisaFilter = '';  // <-- ini untuk pilihan dropdown
    public string $weekAnalisaFilter = '';  // <-- ini untuk pilihan dropdown


    public string $vendorName = '';
    public string $zoneName = '';
    public string $monthAnalisa = '';
    public string $weekAnalisa = '';


    public function mount()
    {
        $user = auth()->user();

        if ($user->type != 1) {
            return redirect()->route('form-input.list');
        }
    }

    public function filter()
    {
        $this->vendorName = $this->vendorNameFilter;
        $this->zoneName = $this->vendorZoneFilter;
        $this->monthAnalisa = $this->monthAnalisaFilter;
        $this->weekAnalisa = $this->weekAnalisaFilter;
    }

    public function render()
    {
        $vendors = Vendor::query()
            ->when($this->vendorName, function ($query) {
                $query->where('name', 'like', $this->vendorName . '%');
            })
            ->when($this->zoneName, function ($query) {
                $query->where('zone', 'like', '%' . $this->zoneName . '%');
            })
            ->withCount('projects')
            ->withCount([
                'projects as total_open' => fn($q) => $q->where('type', StatusPekerjaan::OPEN->value),
                'projects as total_survey' => fn($q) => $q->where('type', StatusPekerjaan::SURVEY->value),
                'projects as total_foc' => fn($q) => $q->where('type', StatusPekerjaan::FOC->value),
                'projects as total_tracing' => fn($q) => $q->where('type', StatusPekerjaan::TRACING->value),
                'projects as total_jointing' => fn($q) => $q->where('type', StatusPekerjaan::JOINTING->value),
                'projects as total_fot' => fn($q) => $q->where('type', StatusPekerjaan::FOT->value),
                'projects as total_closed' => fn($q) => $q->where('type', StatusPekerjaan::CLOSED->value),
            ])
            ->selectSub(function ($query) {
                $query->from('project_updates')
                    ->selectRaw("
                SUM(
                    CASE
                        WHEN job_status IN (?, ?, ?, ?)
                        THEN 0
                        ELSE estimated_pull - actual_pull
                    END
                )
            ", [
                        StatusPekerjaan::CLOSED->value,
                        StatusPekerjaan::FOT->value,
                        StatusPekerjaan::JOINTING->value,
                        StatusPekerjaan::TRACING->value
                    ])
                    ->whereColumn('vendor_id', 'vendors.id');
            }, 'remaining_pull')
            ->selectSub(function ($query) {
                $query->from('project_updates')
                    ->selectRaw("
                SUM(
                    CASE
                        WHEN job_status = ?
                        THEN 0
                        ELSE estimated_tracing - actual_tracing
                    END
                )
            ", [
                        StatusPekerjaan::CLOSED->value
                    ])
                    ->whereColumn('vendor_id', 'vendors.id');
            }, 'remaining_tracing')
            ->get();

//        foreach ($vendors as $vendor) {
//            if ($vendor->id == 3) {
//                dd($vendor->toArray());
//            }
//        }


//        foreach($vendors as $v) {
//            echo "id: {$v->id}, code: {$v->code}\<br>";
//        }
//        dd();

        // tambahkan kolom custom di setiap item
       $vendors->transform(function ($vendor) {
            // contoh hitung total remaining
//           if($vendor->id == 2) dd($vendor->toArray());
            $vendor->calculation = CalculationHelper::AnalisaFTE($vendor->toArray());

            return $vendor;
        });

        // Filter collection by monthAnalisaFilter jika ada isinya
        if ($this->monthAnalisa) {
            $vendors = $vendors->filter(fn($vendor) =>
                isset($vendor->calculation['month_analisa'])
                && $vendor->calculation['month_analisa'] === $this->monthAnalisa
            )->values();
        }

        if ($this->weekAnalisa) {
            $vendors = $vendors->filter(fn($vendor) =>
                isset($vendor->calculation['week_analisa'])
                && $vendor->calculation['week_analisa'] === $this->weekAnalisa
            )->values();
        }

//        dd($vendors->toArray());

        return view('livewire.dashboard.main-dashboard', [
            'summary' => $vendors,
        ]);
    }
}
