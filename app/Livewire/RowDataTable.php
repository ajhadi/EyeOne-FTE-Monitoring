<?php

namespace App\Livewire;

use App\Models\ProjectUpdate;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class RowDataTable extends DataTableComponent
{
    protected $model = Vendor::class;

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

        // Set default sorting by Total Update Dispos (descending)
        $this->setDefaultSort('total_update_dispos', 'desc');
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
            'vendors.code as vendor_code',
        ];

        // PA1 - PA7 (berdasarkan disposition_date project) - kumulatif sampai hari ke-i
        for ($i = 0; $i < 7; $i++) {
            $endDay = $startDate->copy()->addDays($i)->toDateString();
            $selects[] = DB::raw("(SELECT COUNT(*) FROM projects WHERE vendor_id = vendors.id AND disposition_date <= '{$endDay}') as PA" . ($i + 1));
        }

        // Total Update Dispos - berdasarkan disposition_date project dari hari 1 sampai hari 7
        $selects[] = DB::raw("(SELECT COUNT(*) FROM projects WHERE vendor_id = vendors.id AND disposition_date BETWEEN '{$startDate->toDateString()}' AND '{$endDate->toDateString()}') as total_update_dispos");

        // Month & Week info
        $selects[] = DB::raw("MONTH('{$startDate->toDateString()}') as month_number");
        $selects[] = DB::raw("WEEK('{$startDate->toDateString()}') as week_number");
        $selects[] = DB::raw("'{$startDate->toDateString()}' as start_date_week");
        $selects[] = DB::raw("'{$endDate->toDateString()}' as end_date_week");

        // Day1 - Day7 (berdasarkan DATE(created_at) dari project_updates) - untuk semua data
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString();
            $selects[] = DB::raw("(SELECT COUNT(*) FROM project_updates WHERE vendor_id = vendors.id AND DATE(created_at) = '{$date}') as Day" . ($i + 1));
        }

        // Total Update - berdasarkan DATE(created_at) dari project_updates
        $selects[] = DB::raw("(SELECT COUNT(*) FROM project_updates WHERE vendor_id = vendors.id AND DATE(created_at) BETWEEN '{$startDate->toDateString()}' AND '{$endDate->toDateString()}') as total_update");

        // Query langsung ke vendors dengan subquery
        return Vendor::query()
            ->select($selects)
            ->orderBy(DB::raw("(SELECT COUNT(*) FROM projects WHERE vendor_id = vendors.id AND disposition_date BETWEEN '{$startDate->toDateString()}' AND '{$endDate->toDateString()}')"), 'desc')
            ->orderBy('code');
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
