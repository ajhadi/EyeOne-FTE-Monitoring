<?php

namespace App\Livewire;

use App\Enums\StatusPekerjaan;
use App\Models\Project;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ProjectsTable extends DataTableComponent
{
    protected $model = Project::class;

    protected $listeners = ['refresh-projects-table' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchIcon('heroicon-m-magnifying-glass');

        $this->setSearchIconAttributes([
            'class' => 'h-4 w-4',
            'style' => 'color: #000000',
        ]);

        $this->setFilterLayoutSlideDown();
    }

    public function columns(): array
    {
        return [


//            Column::make("No. PA", "pa_number")
//                ->sortable(),

            Column::make("No. Kontrak", "contract_number")
                ->sortable()
                ->searchable(),
            Column::make("Alamat", "customer_address")
                ->sortable()
                ->searchable()
                ->hideIf(1 == 1),
            Column::make("Pelanggan", "customer_name")
                ->format(function ($value, $row, Column $column) {
                    return <<<HTML
                        <span class="font-normal">{$row->customer_name}</span><br>
                        <span class="text-xs">{$row->customer_address}</span>
                    HTML;
                })
                ->searchable()
                ->html(),

            Column::make("ptl")->searchable(),

            Column::make("vendor", 'vendor.name'),

            Column::make("Tgl Disposisi", 'disposition_date'),
            Column::make("Tgl Target", 'target_date'),

            Column::make("Durasi", 'disposition_date')
                ->format(function ($value, $row, Column $column) {
                    $disposisi = \Carbon\Carbon::parse($row->disposition_date);
                    $target = \Carbon\Carbon::parse($row->target_date);

                    // Selalu hasil positif
                    $days = $disposisi->diffInDays($target);

                    return $days;
                }),


            Column::make('Tipe PA', 'type')
                ->format(function ($value, $row, Column $column) {
                    $status = StatusPekerjaan::from($row->type);
                    $desc = $status->description();
                    $class = $status->badgeColor();

                    return "<span class=\"$class text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm\">$desc</span>";
                })
                ->html(),

            Column::make('PA Create', 'created_at')
                ->format(function ($value, $row, Column $column) {
                    return \Carbon\Carbon::parse($value)->format('Y-m-d');
                })
                ->sortable(),

        ];
    }

    public function filters(): array
    {
        return [
            MultiSelectFilter::make('Status Pekerjaan')
                ->options(
                  StatusPekerjaan::toSelectOptionsV2()
                )->filter(function(Builder $builder, array $values) {
                    $builder->whereIn('type', $values);
                })->setInputAttributes([
                    'maxlength' => '75',
                    'placeholder' => 'Enter a Name',
                    'class' => 'text-white bg-red-500 dark:bg-red-500',
                    'default-colors' => false,
                    'default-styling' => true,
                ]),
            DateRangeFilter::make('Tanggal Disposisi')
                ->config([
                    'allowInput' => true,   // Allow manual input of dates
                    'altFormat' => 'F j, Y', // Date format that will be displayed once selected
                    'ariaDateFormat' => 'F j, Y', // An aria-friendly date format
                    'dateFormat' => 'Y-m-d', // Date format that will be received by the filter
                    'earliestDate' => '2020-01-01', // The earliest acceptable date
                    'placeholder' => 'Enter Date Range', // A placeholder value
                    'locale' => 'en',
                ])
                ->setFilterPillValues([0 => 'minDate', 1 => 'maxDate']) // The values that will be displayed for the Min/Max Date Values
                ->filter(function (Builder $builder, array $dateRange) { // Expects an array.
                    $builder
                        ->whereDate('disposition_date', '>=', $dateRange['minDate']) // minDate is the start date selected
                        ->whereDate('disposition_date', '<=', $dateRange['maxDate']); // maxDate is the end date selected
                }),
            SelectFilter::make('Vendor')
                ->options([
                    '' => 'All',
                    $vendors = Vendor::query()
                        ->orderBy('name')
                        ->get()
                        ->keyBy('id')
                        ->map(fn($vendor) => $vendor->name)
                        ->toArray()
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('vendor_id', $value);
                }),
        ];
    }

}
