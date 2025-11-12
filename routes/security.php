<?php


use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['auth'])->group(function () {
    Route::redirect('security', 'security/users');

    Volt::route('security/users', 'users.list')->name('users.list');
});
