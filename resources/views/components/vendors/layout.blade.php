@props([
    'heading' => '',
    'subheading' => '',
    'vendorId' => null,
])

<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            {{-- Gunakan array syntax --}}
            <flux:navlist.item :href="route('vendors.details', ['id' => $vendorId])" wire:navigate>
                {{ __('Vendor') }}
            </flux:navlist.item>

            <flux:navlist.item :href="route('vendors.projects', ['id' => $vendorId])" wire:navigate>
                {{ __('Project') }}
            </flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading }}</flux:heading>
        <flux:subheading>{{ $subheading }}</flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
