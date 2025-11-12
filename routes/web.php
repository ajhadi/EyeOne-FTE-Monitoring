<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard;
use App\Livewire\RowData;
use Livewire\Volt\Volt;

Route::get('/', function () {
    // Redirect ke dashboard jika sudah login, ke login jika belum
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', Dashboard\MainDashboard::class)->name('dashboard');
    Route::get('dashboard/data-abk', Dashboard\DataABK::class)->name('data-abk');
    Route::get('row-data', RowData\Index::class)->name('row-data');
    Route::get('query', [\App\Http\Controllers\QueryController::class,'days'])->name('query');
    Volt::route('form-input', 'form-input.list')->name('form-input.list');

    Volt::route('vendors', 'vendors.list')->name('vendors.list');

    Route::redirect('vendors/{id}', 'vendors/{id}/details');
    Volt::route('vendors/{id}/details', 'vendors.detail')->name('vendors.details');
    Volt::route('vendors/{id}/projects', 'vendors.projects')->name('vendors.projects');

    Volt::route('projects', 'projects.list')->name('projects.list');
    Volt::route('projects/{id}', 'projects.detail')->name('projects.detail');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/security.php';
