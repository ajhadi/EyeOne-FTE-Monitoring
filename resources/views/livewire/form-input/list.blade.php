<section class="w-full">
    <div class="w-full flex flex-row justify-between mb-4">
        <div
            class="flex justify-center items-center ">
            <div class="w-14 flex-none justify-items-center-safe">
                <flux:icon.chart-pie class="w-12 h-12"/>
            </div>
            <div class="flex-1 ml-2">
                <div class="text-xl font-medium text-gray-700">Data Form Input</div>
                <div class="flex justify-center items-end">
                    <div class="flex-1 text-sm text-gray-500">Daily Progress Vendor KHS PT PLN</div>
                </div>
            </div>
        </div>

        <livewire:form-input.add/>

    </div>

    <flux:separator/>


    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 mt-4">
        <livewire:project-update-table/>
    </div>
</section>
