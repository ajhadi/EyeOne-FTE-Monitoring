<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class=" rounded-xl border bg-white border-neutral-200 dark:border-neutral-700 p-5">
        {{--        <div class="grid gap-4 md:grid-cols-4">--}}
        <!-- Total Company -->
        <div
            class="flex justify-center items-center ">
            <div class="w-14 flex-none justify-items-center-safe">
                <flux:icon.monitor-check class="w-12 h-12"/>
            </div>
            <div class="flex-1 ml-2">
                <div class="text-xl font-medium text-gray-700">Row Data</div>
                <div class="flex justify-center items-end">
                    <div class="flex-1 text-sm text-gray-500">Last update 7 hrs ago</div>
                </div>
            </div>
        </div>
        {{--        </div>--}}
    </div>
    <div class="relative overflow-hidden rounded-xl border bg-white border-neutral-200 dark:border-neutral-700 p-5">
        <div class="grid gap-4 md:grid-cols-5">
            <!-- Total Update -->
            <div
                class="flex items-center bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 rounded-xl px-4 py-6 shadow">
                <div class="w-34">
                    <div class="text-md font-medium text-gray-700">Total Update</div>
                    <div class="flex items-end">
                        <div class="text-2xl font-bold text-gray-900">{{$totalUpdate}}</div>
                        <div class="text-sm text-gray-500 m-1">/{{$totalProjects}} PA</div>
                    </div>
                </div>
            </div>
            <!-- Not Update -->
            <div
                class="flex items-center bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 rounded-xl px-4 py-6 shadow">
                <div class="w-34">
                    <div class="text-md font-medium text-gray-700">Not Update</div>
                    <div class="flex items-end">
                        <div class="text-2xl font-bold text-gray-900">{{$totalNotUpdate}}</div>
                        <div class="text-sm text-gray-500 m-1">/{{$totalProjects}} PA</div>
                    </div>
                </div>
            </div>
            <!-- Average -->
            <div
                class="flex items-center bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 rounded-xl px-4 py-6 shadow">
                <div class="w-34">
                    <div class="text-md font-medium text-gray-700">Average %</div>
                    <div class="flex items-end">
                        <div class="text-2xl font-bold text-gray-900">{{$average}}</div>
                        <div class="text-sm text-gray-500 m-1">/100%</div>
                    </div>
                </div>
            </div>
            <!-- Days -->
            <div
                class="flex items-center bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 rounded-xl px-4 py-6 shadow">
                <div class="w-34">
                    <div class="text-md font-medium text-gray-700">Days</div>
                    <div class="flex items-end">
                        <div class="text-2xl font-bold text-gray-900">{{ $days }}</div>
                        <div class="text-sm text-gray-500 m-1">/7 Days</div>
                    </div>
                </div>
            </div>
            <!-- Weeks -->
            <div
                class="flex items-center bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 rounded-xl px-4 py-6 shadow">
                <div class="w-34">
                    <div class="text-md font-medium text-gray-700">Weeks</div>
                    <div class="flex items-end">
                        <div class="text-2xl font-bold text-gray-900">{{ $weeks }}</div>
                        <div class="text-sm text-gray-500 m-1">/{{$weeksInYear}} Weeks</div>
                    </div>
                </div>
            </div>
            <!-- download -->
{{--            <div--}}
{{--                class="flex items-center">--}}
{{--                <button class="w-full bg-red-500 text-white flex items-center justify-center rounded px-2 py-3 ">--}}
{{--                    <flux:icon.download/>--}}
{{--                    .xls--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <!-- update -->--}}
{{--            <div--}}
{{--                class="flex items-center">--}}
{{--                <button class="w-full bg-green-500 text-white flex items-center justify-center rounded px-2 py-3 ">--}}
{{--                    <flux:icon.refresh-ccw/>--}}
{{--                    Update--}}
{{--                </button>--}}
{{--            </div>--}}
        </div>
    </div>

    <div class="bg-white rounded-xl border border-neutral-200 dark:border-neutral-700 p-5">
        <div class="grid grid-cols-2 gap-4 ">
            <div class="flex items-center">
                <div class="text-2xl font-bold text-gray-900">Row Data</div>
            </div>
            <div class="justify-items-end">
{{--                <button class="bg-red-500 text-white flex items-center justify-center rounded px-2 py-3 ">--}}
{{--                    <flux:icon.file-chart-column-increasing/>--}}
{{--                    Summary Report--}}
{{--                </button>--}}
            </div>
        </div>
        <div class="mt-5">
            <livewire:row-data-table />
        </div>
    </div>
</div>

