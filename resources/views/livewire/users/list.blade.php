
<section class="w-full">
    <div class="w-full flex flex-row justify-between">

        <div>
            <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('Pengelolaan data users') }}</flux:subheading>

        </div>

        <livewire:users.add />

    </div>

    <flux:separator />


    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 mt-4">
        <livewire:users-table />
    </div>
</section>
