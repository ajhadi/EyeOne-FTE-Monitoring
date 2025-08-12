<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="rounded-xl border bg-white border-neutral-200 dark:border-neutral-700 p-5 flex justify-between items-center">
        <div class="flex justify-center items-end">
            <div class="flex-0 font-bold text-gray-900"><a href="{{route('dashboard')}}">[Dashboard]</a>
            </div>
            <div class="flex-0 text-gray-500"> <flux:icon.chevrons-right/> </div>
            <div class="flex-1 ext-gray-500">Data ABK</div>
        </div>

        <div>
{{--            <button class="bg-red-500 text-white flex items-center justify-center rounded px-2 py-3 ">--}}
{{--                <flux:icon.file-chart-column-increasing/>--}}
{{--                Summary Report--}}
{{--            </button>--}}

            <livewire:dashboard.add-project />
        </div>

    </div>
    <div class="relative overflow-hidden rounded-xl border bg-white border-neutral-200 dark:border-neutral-700 p-5">
        <div class="grid gap-4 md:grid-cols-7">
            <x-abk-count label="OPEN" :count="$open" />
            <x-abk-count label="SURVEY" :count="$survey" />
            <x-abk-count label="FOC" :count="$foc" />
            <x-abk-count label="TRACING" :count="$tracing" />
            <x-abk-count label="JOINTING" :count="$jointing" />
            <x-abk-count label="FOT" :count="$fot" />
            <x-abk-count label="CLOSED" :count="$closed" color="red" />
        </div>
    </div>

{{--    <div class="relative overflow-hidden rounded-xl border bg-white border-neutral-200 dark:border-neutral-700 p-5">--}}
{{--        <div class="grid grid-cols-4 gap-4">--}}
{{--            <flux:field>--}}
{{--                <flux:label>Project Id</flux:label>--}}
{{--                <flux:select wire:model="industry" placeholder="Choose industry...">--}}
{{--                    <flux:select.option>Photography</flux:select.option>--}}
{{--                    <flux:select.option>Design services</flux:select.option>--}}
{{--                    <flux:select.option>Web development</flux:select.option>--}}
{{--                    <flux:select.option>Accounting</flux:select.option>--}}
{{--                    <flux:select.option>Legal services</flux:select.option>--}}
{{--                    <flux:select.option>Consulting</flux:select.option>--}}
{{--                    <flux:select.option>Other</flux:select.option>--}}
{{--                </flux:select>--}}
{{--                <flux:error name="username"/>--}}
{{--            </flux:field>--}}
{{--            <flux:field>--}}
{{--                <flux:label>Customer Name</flux:label>--}}
{{--                <flux:select wire:model="industry" placeholder="Choose industry...">--}}
{{--                    <flux:select.option>Photography</flux:select.option>--}}
{{--                    <flux:select.option>Design services</flux:select.option>--}}
{{--                    <flux:select.option>Web development</flux:select.option>--}}
{{--                    <flux:select.option>Accounting</flux:select.option>--}}
{{--                    <flux:select.option>Legal services</flux:select.option>--}}
{{--                    <flux:select.option>Consulting</flux:select.option>--}}
{{--                    <flux:select.option>Other</flux:select.option>--}}
{{--                </flux:select>--}}
{{--                <flux:error name="username"/>--}}
{{--            </flux:field>--}}
{{--            <flux:field>--}}
{{--                <flux:label>Customer Address</flux:label>--}}
{{--                <flux:select wire:model="industry" placeholder="Choose industry...">--}}
{{--                    <flux:select.option>Photography</flux:select.option>--}}
{{--                    <flux:select.option>Design services</flux:select.option>--}}
{{--                    <flux:select.option>Web development</flux:select.option>--}}
{{--                    <flux:select.option>Accounting</flux:select.option>--}}
{{--                    <flux:select.option>Legal services</flux:select.option>--}}
{{--                    <flux:select.option>Consulting</flux:select.option>--}}
{{--                    <flux:select.option>Other</flux:select.option>--}}
{{--                </flux:select>--}}
{{--                <flux:error name="username"/>--}}
{{--            </flux:field>--}}
{{--            <flux:field>--}}
{{--                <flux:label>Project Team Leader</flux:label>--}}
{{--                <flux:select wire:model="industry" placeholder="Choose industry...">--}}
{{--                    <flux:select.option>Photography</flux:select.option>--}}
{{--                    <flux:select.option>Design services</flux:select.option>--}}
{{--                    <flux:select.option>Web development</flux:select.option>--}}
{{--                    <flux:select.option>Accounting</flux:select.option>--}}
{{--                    <flux:select.option>Legal services</flux:select.option>--}}
{{--                    <flux:select.option>Consulting</flux:select.option>--}}
{{--                    <flux:select.option>Other</flux:select.option>--}}
{{--                </flux:select>--}}
{{--                <flux:error name="username"/>--}}
{{--            </flux:field>--}}
{{--            <flux:field>--}}
{{--                <flux:label>Company</flux:label>--}}
{{--                <flux:select wire:model="industry" placeholder="Choose industry...">--}}
{{--                    <flux:select.option>Photography</flux:select.option>--}}
{{--                    <flux:select.option>Design services</flux:select.option>--}}
{{--                    <flux:select.option>Web development</flux:select.option>--}}
{{--                    <flux:select.option>Accounting</flux:select.option>--}}
{{--                    <flux:select.option>Legal services</flux:select.option>--}}
{{--                    <flux:select.option>Consulting</flux:select.option>--}}
{{--                    <flux:select.option>Other</flux:select.option>--}}
{{--                </flux:select>--}}
{{--                <flux:error name="username"/>--}}
{{--            </flux:field>--}}
{{--            <flux:field>--}}
{{--                <flux:label>Tipe Kendala</flux:label>--}}
{{--                <flux:select wire:model="industry" placeholder="Choose industry...">--}}
{{--                    <flux:select.option>Photography</flux:select.option>--}}
{{--                    <flux:select.option>Design services</flux:select.option>--}}
{{--                    <flux:select.option>Web development</flux:select.option>--}}
{{--                    <flux:select.option>Accounting</flux:select.option>--}}
{{--                    <flux:select.option>Legal services</flux:select.option>--}}
{{--                    <flux:select.option>Consulting</flux:select.option>--}}
{{--                    <flux:select.option>Other</flux:select.option>--}}
{{--                </flux:select>--}}
{{--                <flux:error name="username"/>--}}
{{--            </flux:field>--}}
{{--            <flux:field>--}}
{{--                <flux:label>Status Pekerjaan</flux:label>--}}
{{--                <flux:select wire:model="industry" placeholder="Choose industry...">--}}
{{--                    <flux:select.option>Photography</flux:select.option>--}}
{{--                    <flux:select.option>Design services</flux:select.option>--}}
{{--                    <flux:select.option>Web development</flux:select.option>--}}
{{--                    <flux:select.option>Accounting</flux:select.option>--}}
{{--                    <flux:select.option>Legal services</flux:select.option>--}}
{{--                    <flux:select.option>Consulting</flux:select.option>--}}
{{--                    <flux:select.option>Other</flux:select.option>--}}
{{--                </flux:select>--}}
{{--                <flux:error name="username"/>--}}
{{--            </flux:field>--}}
{{--            <div class="flex items-end">--}}
{{--                <div class="w-14 flex-none">--}}
{{--                    <button class="bg-zinc-50 flex items-center justify-center rounded-full w-12 h-12">--}}
{{--                        <flux:icon.funnel/>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="w-64 flex-1 ">--}}
{{--                    <button class="bg-red-500 text-white flex items-center justify-center rounded px-2 py-3 ">--}}
{{--                        <flux:icon.file-chart-column-increasing/>--}}
{{--                        Summary Report--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div
        class="relative h-full flex-1 overflow-hidden bg-white rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <h3>Data Dashboard ABK (Analisis Bebean Kerja Harian)</h3>
        <div class="mt-5">
            <livewire:projects-table/>
        </div>
    </div>
</div>

