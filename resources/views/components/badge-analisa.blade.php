@props(['status'])

@php
    $colors = match (strtoupper($status)) {
        'MASA PERSIAPAN' => 'bg-white text-gray-700 border border-gray-300',
        'UNDERLOAD' => 'bg-green-500 text-white',
        'FIT' => 'bg-yellow-400 text-black',
        'OVERLOAD' => 'bg-red-500 text-white',
        default => 'bg-gray-300 text-black',
    };
@endphp

<span class="px-3 py-1 text-sm font-semibold rounded-s {{ $colors }}">
    {{ $status }}
</span>
