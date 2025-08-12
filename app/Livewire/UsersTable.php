<?php

namespace App\Livewire;

use App\Models\User;
use App\Enums\JenisUser;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\WireLinkColumn;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    protected $listeners = ['refreshUsersTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchIcon('heroicon-m-magnifying-glass');

        $this->setSearchIconAttributes([
            'class' => 'h-4 w-4',
            'style' => 'color: #000000',
        ]);
    }


    public function builder(): Builder
    {
        return User::query()
            ->where('type', '<>', JenisUser::VENDOR->value);
    }

    public function delete($id): void
    {
        $user = User::find($id);

        $userManagement = new \WorkOS\UserManagement();

        $userManagement->deleteUser($user->workos_id);
        $user->delete();

        $this->dispatch('refreshUsersTable')->self();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make('Avatar')
                ->format(function ($value, $row, Column $column) {
                    return <<<HTML
                        <img alt="{$row->name}" src="{$row->avatar}" class="rounded-full w-10 h-10" />
                    HTML;
                })
                ->html(),
            Column::make('Type')
                ->format(
                    fn($value, $row, Column $column) => '<strong>'. JenisUser::from($row->type)->description() .'</strong>'
                )
                ->html(),
            Column::make("Created at", "created_at")
                ->sortable(),
        ];
    }
}
