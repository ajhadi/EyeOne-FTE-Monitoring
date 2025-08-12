<?php

namespace App\Livewire;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DashboardTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nama Perusahaan", "companyName")
                ->sortable(),
            Column::make("Wilayah Kerja", "jobArea")
                ->sortable(),
            Column::make("Jumlah Tim", "numberofTeam")
                ->sortable(),
            Column::make("Orang(s)", "people")
                ->sortable(),
            Column::make("Consumed Man-Days", "consumedManDays")
                ->sortable(),
            Column::make("Jumlah Disposisi Po", "disposisiPo")
                ->sortable(),
            Column::make("1 Minggu ke Depan", "oneWeekAhead")
                ->sortable(),
            Column::make("1 Bulan ke Depan", "oneMonthAhead")
                ->sortable(),
        ];
    }
}
