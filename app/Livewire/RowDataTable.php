<?php

namespace App\Livewire;

use App\Models\ProjectUpdate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class RowDataTable extends DataTableComponent
{
    protected $model = ProjectUpdate::class;

    /**
     * @inheritDoc
     */
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchIcon('heroicon-m-magnifying-glass');

        $this->setSearchIconAttributes([
            'class' => 'h-4 w-4',
            'style' => 'color: #000000',
        ]);

        // Set default sorting by Total Update (descending)
        $this->setDefaultSort('total_update', 'desc');
    }

    public function builder(): Builder
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();

        // Ambil awal minggu (Senin)  
        $startDate = $today->copy()->startOfWeek(Carbon::MONDAY);

        // Ambil akhir minggu (Minggu)
        $endDate = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $selects = [
            'v.code as vendor_code',
        ];

        // PA1 - PA7 (berdasarkan created_at) - untuk semua data
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString();
            $selects[] = DB::raw("SUM(CASE WHEN DATE(pu.created_at) = '{$date}' THEN 1 ELSE 0 END) as PA" . ($i + 1));
        }

        // Total Update Dispos - untuk semua data
        $selects[] = DB::raw("SUM(CASE WHEN DATE(p.disposition_date) BETWEEN '{$startDate->toDateString()}' AND '{$endDate->toDateString()}' THEN 1 ELSE 0 END) as total_update_dispos");

        // Month & Week info
        $selects[] = DB::raw("MONTH('{$startDate->toDateString()}') as month_number");
        $selects[] = DB::raw("WEEK('{$startDate->toDateString()}') as week_number");
        $selects[] = DB::raw("'{$startDate->toDateString()}' as start_date_week");
        $selects[] = DB::raw("'{$endDate->toDateString()}' as end_date_week");

        // Day1 - Day7 (berdasarkan pu.date) - untuk semua data
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString();
            $selects[] = DB::raw("SUM(CASE WHEN pu.date = '{$date}' THEN 1 ELSE 0 END) as Day" . ($i + 1));
        }

        // Total Update - untuk semua data 
        $selects[] = DB::raw("SUM(CASE WHEN pu.date BETWEEN '{$startDate->toDateString()}' AND '{$endDate->toDateString()}' THEN 1 ELSE 0 END) as total_update");

        // Query utama - TANPA WHERE date filter agar mengambil semua data
        return ProjectUpdate::query()
            ->from('project_updates as pu')
            ->join('vendors as v', 'pu.vendor_id', '=', 'v.id')
            ->join('projects as p', 'pu.project_id', '=', 'p.id')
            ->select($selects)
            ->groupBy('v.code')
            ->orderBy(DB::raw('SUM(CASE WHEN pu.date BETWEEN \'' . $startDate->toDateString() . '\' AND \'' . $endDate->toDateString() . '\' THEN 1 ELSE 0 END)'), 'desc')
            ->orderBy('v.code');
    }

    public function columns(): array
    {
        return [
            Column::make("Vendor")
                ->label(fn($row) => $row->vendor_code)
                ->searchable()
                ->sortable(),
            Column::make("PA1")
                ->label(fn($row) => $row->PA1)
                ->sortable(),
            Column::make("PA2")
                ->label(fn($row) => $row->PA2)
                ->sortable(),
            Column::make("PA3")
                ->label(fn($row) => $row->PA3)
                ->sortable(),
            Column::make("PA4")
                ->label(fn($row) => $row->PA4)
                ->sortable(),
            Column::make("PA5")
                ->label(fn($row) => $row->PA5)
                ->sortable(),
            Column::make("PA6")
                ->label(fn($row) => $row->PA6)
                ->sortable(),
            Column::make("PA7")
                ->label(fn($row) => $row->PA7)
                ->sortable(),
            Column::make("Total Update Dispos")
                ->label(fn($row) => $row->total_update_dispos)
                ->sortable(),
            Column::make("Month")
                ->label(fn($row) => $row->month_number),
            Column::make("Week")
                ->label(fn($row) => $row->week_number),
            Column::make("Start Date Of Week")
                ->label(fn($row) => Carbon::parse($row->start_date_week)->format('d/m/Y')),
            Column::make("End Date Of Week")
                ->label(fn($row) => Carbon::parse($row->end_date_week)->format('d/m/Y')),
            Column::make("DAY1")
                ->label(fn($row) => $row->Day1)
                ->sortable(),
            Column::make("DAY2")
                ->label(fn($row) => $row->Day2)
                ->sortable(),
            Column::make("DAY3")
                ->label(fn($row) => $row->Day3)
                ->sortable(),
            Column::make("DAY4")
                ->label(fn($row) => $row->Day4)
                ->sortable(),
            Column::make("DAY5")
                ->label(fn($row) => $row->Day5)
                ->sortable(),
            Column::make("DAY6")
                ->label(fn($row) => $row->Day6)
                ->sortable(),
            Column::make("DAY7")
                ->label(fn($row) => $row->Day7)
                ->sortable(),
            Column::make("Total Update")
                ->label(fn($row) => $row->total_update)
                ->sortable(),
            Column::make("Total Days in a Week")
                ->label(fn($row) => 7),
            Column::make("Percentage")
                ->label(fn($row) => $row->total_update > 0
                    ? round(($row->total_update_dispos / $row->total_update) * 100, 2) . '%'
                    : '0%'
                )
                ->sortable(),
        ];
    }
}
