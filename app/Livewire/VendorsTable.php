<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Vendor;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\WireLinkColumn;

class VendorsTable extends DataTableComponent
{
    protected $model = Vendor::class;

    protected $listeners = ['refresh-vendor-table' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchIcon('heroicon-m-magnifying-glass');

        $this->setSearchIconAttributes([
            'class' => 'h-4 w-4',
            'style' => 'color: #000000',
        ]);

        $this->setTableRowUrl(function($row) {
                return route('vendors.details', ['id' => $row->id]);
            })
            ->setTableRowUrlTarget(function($row) {
                return '_self';
            });
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Kode", "code"),
            Column::make("Nama", "name")
                ->sortable()
                ->searchable(),
            Column::make("Alamat", "address")
                ->sortable()
                ->searchable(),
            Column::make("Telp", 'phone'),
            Column::make("Area", 'zone'),
            Column::make("Team", 'team_count'),
            Column::make("Anggota", 'members_per_team'),
            Column::make("Created at", "created_at")
                ->sortable(),
        ];
    }
}
