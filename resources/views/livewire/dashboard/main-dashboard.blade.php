<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="relative overflow-hidden rounded-xl border bg-white border-neutral-200 dark:border-neutral-700 p-5">
        <h1>Welcome to, Monitoring FTE!</h1>
    </div>
    <div class="relative overflow-hidden rounded-xl border bg-white border-neutral-200 dark:border-neutral-700 p-5">
        <div class="grid grid-cols-5 gap-4 items-end">
            <flux:field>
                <flux:label>Company</flux:label>
                <!-- pakai defer supaya tidak tiap ketik mengirim request -->
                <flux:input wire:model.defer="vendorNameFilter" placeholder="Cari perusahaan..." />
            </flux:field>

            <flux:field>
                <flux:label>Work Area</flux:label>
                <flux:input wire:model.defer="vendorZoneFilter" placeholder="Cari zona..." />
            </flux:field>

            <flux:field>
                <flux:label>Status For Week</flux:label>
                <!-- pakai defer supaya tidak tiap ketik mengirim request -->

                <flux:select placeholder="Choose week analisa..." wire:model.defer="weekAnalisaFilter">
                    <flux:select.option value="">-- All --</flux:select.option> <!-- opsional, untuk reset filter -->
                    <flux:select.option>MASA PESIAPAN</flux:select.option>
                    <flux:select.option>UNDERLOAD</flux:select.option>
                    <flux:select.option>FIT</flux:select.option>
                    <flux:select.option>OVERLOAD</flux:select.option>
                </flux:select>
            </flux:field>

            <flux:field>
                <flux:label>Status For Month</flux:label>
                <!-- pakai defer supaya tidak tiap ketik mengirim request -->

                <flux:select placeholder="Choose month analisa..." wire:model.defer="monthAnalisaFilter">
                    <flux:select.option value="">-- All --</flux:select.option> <!-- opsional, untuk reset filter -->
                    <flux:select.option>MASA PESIAPAN</flux:select.option>
                    <flux:select.option>UNDERLOAD</flux:select.option>
                    <flux:select.option>FIT</flux:select.option>
                    <flux:select.option>OVERLOAD</flux:select.option>
                </flux:select>
            </flux:field>


            <flux:button variant="primary" wire:click="filter">Primary</flux:button>
        </div>
    </div>

    <livewire:dashboard.dashboard-stat-container />

    <div
        class="relative h-full flex-1 overflow-hidden bg-white rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <h3>Dashboard Status Vendor</h3>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Perusahaan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Wilayah<br>Kerja
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jumlah<br>Tim
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Orang(s)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Consumed<br>Days
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jumlah<br>Disposisi PO
                    </th>

                    <th scope="col" class="px-6 py-3">
                        1 Minggu<br>Ke Depan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        1 Bulan<br>Ke Depan
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($summary as $vendor)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $vendor->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $vendor->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $vendor->zone }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $vendor->team_count }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $vendor->members_per_team * $vendor->team_count  }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $vendor->calculation['consumed_days'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $vendor->projects_count }}
                        </td>
                        <td class="px-6 py-4">
                            <x-badge-analisa :status="$vendor->calculation['week_analisa']" />
                        </td>
                        <td class="px-6 py-4">
                            <x-badge-analisa :status="$vendor->calculation['month_analisa']" />
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

{{--            {{ $summary->links() }}--}}

        </div>
    </div>
</div>
