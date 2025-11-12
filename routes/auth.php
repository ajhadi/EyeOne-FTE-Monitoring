<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

// Login page
Route::get('login', function () {
    return view('auth.login');
})->middleware(['guest'])->name('login');

// Login process
Route::post('login', function (Request $request) {
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Hardcode admin login
    if ($credentials['username'] === 'admin' && $credentials['password'] === 'admin') {
        // Get or create admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'workos_id' => 'user_admin_default'
            ]
        );

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
})->middleware(['guest']);

// Logout
Route::post('logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/login');
})->middleware(['auth'])->name('logout');
