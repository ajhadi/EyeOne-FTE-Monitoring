<?php

use App\Models\Project;
use function Livewire\Volt\{state, usesPagination, mount, with};

// Aktifkan pagination
usesPagination();

// Simpan ID vendor ke dalam state
state('vendor');

mount(function (int $id) {
    $this->vendor = \App\Models\Vendor::find($id);
});

// Ambil project yang sesuai vendor ID dan paginasi
with(fn() => [
    'projects' => Project::where('vendor_id', $this->vendor->id)
        ->orderBy('id', 'desc')
        ->paginate(10),
]);

?>

<section class="w-full">
    @include('partials.vendors-heading', ['vendorName' => $vendor->name])

    {{-- Pass the vendor ID into the layout --}}
    <x-vendors.layout
        :heading="__('Data project')"
        :subheading="__('Lihat semua project pada vendor')"
        :vendorId="$vendor->id"
    >
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No. Kontrak
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Pelanggan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        PTL
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tgl Disposisi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tgl Target
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($projects as $project)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $project->contract_number }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $project->customer_name }} <br>
                        {{ $project->customer_address }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $project->ptl }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $project->disposition_date }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $project->target_date }}
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>

            {{ $projects->links() }}

        </div>


    </x-vendors.layout>
</section>


