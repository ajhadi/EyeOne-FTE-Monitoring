@props([
    'label' => '',
    'count' => 0,
    'color' => 'zinc-50', // default warna
])

@php
    $bgClass = $color === 'red' ? 'bg-red-500' : 'bg-' . $color;
    $textColor = $color === 'red' ? 'text-white' : 'text-gray-900';
@endphp

<div class="text-center {{ $bgClass }} dark:border-zinc-700 dark:bg-zinc-900 rounded-xl px-2 py-2 shadow">
    <div class="text-xl font-medium {{ $color === 'red' ? 'text-gray-900' : 'text-gray-700' }}">
        {{ strtoupper($label) }}
    </div>
    <div class="text-3xl font-bold {{ $textColor }}">{{ $count }}</div>
</div>
