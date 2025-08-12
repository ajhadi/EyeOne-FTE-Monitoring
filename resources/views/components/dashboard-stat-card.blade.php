@props([
    'icon' => '',      // contoh: 'users', 'timer', 'timer-off'
    'title' => '',
    'count' => 0,
    'subtitle' => '',
])

<div class="flex justify-center items-center bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 rounded-xl px-4 py-6 shadow">
    <div class="w-14 flex-1 justify-items-center-safe">
        @if ($icon === 'users')
            <flux:icon.users class="w-12 h-12" />
        @elseif ($icon === 'timer')
            <flux:icon.timer class="w-12 h-12" />
        @elseif ($icon === 'timer-off')
            <flux:icon.timer-off class="w-12 h-12" />
        @else
            <flux:icon.plus class="w-12 h-12" />
        @endif

    </div>
    <div class="w-64 flex-2">
        <div class="text-xl font-medium text-gray-700">{{ $title }}</div>
        <div class="flex justify-center items-end">
            <div class="w-16 flex-0 text-3xl font-bold text-gray-900">{{ $count }}</div>
            <div class="flex-1 text-sm text-gray-500 m-1">{{ $subtitle }}</div>
        </div>
    </div>
</div>
