<?php

use App\Livewire\Forms\VendorEditForm;
use Masmerise\Toaster\Toaster;
use function Livewire\Volt\{state, mount, form};
use App\Models\Vendor;


form(VendorEditForm::class);

state('vendor');

mount(function (int $id) {
    $this->vendor = Vendor::findOrFail($id);
    $this->form->fillFromVendor($this->vendor); // isi form dari vendor
});

$save = function () {
    $this->form->updateVendor($this->vendor); // update data vendor
    session()->flash('success', 'Data vendor berhasil diperbarui!');
    $this->dispatch('vendor-updated');

    Toaster::success('User created!'); // 👈
};
?>

<section class="w-full">
    @include('partials.vendors-heading', ['vendorName' => $vendor->name])

    {{-- Pass the vendor ID into the layout --}}
    <x-vendors.layout
        :heading="__('Detail Vendor')"
        :subheading="__('Ubah data vendor disini')"
        :vendorId="$vendor->id"
    >
        <form wire:submit="save" class="my-6 w-full space-y-6 max-w-3xl">
            <flux:input wire:model="form.code" :label="__('Kode')" type="text" required autofocus autocomplete="code"/>

            <flux:input wire:model="form.name" :label="__('Nama')" type="text" required
                        autocomplete="name"/>

            <flux:textarea
                wire:model="form.address"
                label="Alamat"
                placeholder="jalan ......"
            />

            <flux:input wire:model="form.phone" :label="__('Telepon')" type="text"
                        autocomplete="phone"/>

            <flux:input wire:model="form.zone" :label="__('Area')" type="text"
                        autocomplete="zone"/>

            <flux:input wire:model="form.team_count" :label="__('Jumlah Tim')" type="number"
                        autocomplete="team_count"/>

            <flux:input wire:model="form.members_per_team" :label="__('Jumlah Anggota')" type="number"
                        autocomplete="members_per_team"/>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-vendors.layout>
</section>
