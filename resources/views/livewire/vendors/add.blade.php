<?php

use App\Enums\JenisUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Component;

new class extends Component {
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public bool $is_superadmin = false;

    public string $errorTitle = '';
    public array $errorMessages = [];



    public function addUser(): void
    {
        $this->errorTitle  = '';
        $this->errorMessages = [];

        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'is_superadmin' => ['boolean'],
        ]);

        $type = $validated['is_superadmin'] ? JenisUser::ADMINISTRATOR->value : JenisUser::MEMBER->value;

        $userManagement = new \WorkOS\UserManagement();

        $woUser = null;

        try {
            $woUser = $userManagement->createUser(
                $validated['email'],
                $validated['password'],
                $validated['first_name'],
                $validated['last_name']
            );

        } catch (\Exception $e) {
            $response = json_decode($e->getMessage(), true);

            $this->errorTitle = $response['message'] ?? 'Terjadi kesalahan saat membuat pengguna.';

            $this->errorMessages = collect($response['errors'] ?? [])
                ->pluck('message')
                ->filter()
                ->values()
                ->all();

            // Jika tidak ada detail error, masukkan title saja
            if (empty($this->errorMessages)) {
                $this->errorMessages = [$this->errorTitle];
            }

            return;
        }

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => $type,
            'workos_id' => $woUser->id,
            'avatar' => $woUser->profile_picture_url ?? '',
        ]);


        $this->dispatch('refreshUsersTable');

        // Reset input fields
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->password = '';
        $this->is_superadmin = false;
    }
};
?>


<div>
    <flux:modal.trigger name="add-user">
        <flux:button variant="primary" color="zinc">Tambah Pengguna</flux:button>
    </flux:modal.trigger>

    <flux:modal name="add-user" class="md:min-w-2xl" submit="addUser">
        <div class="space-y-6">
            <div class="py-2">
                <flux:heading size="lg">Tambah Pengguna Baru</flux:heading>
                <flux:text class="mt-2">Isi informasi pengguna di bawah ini.</flux:text>
            </div>


            @if (!empty($errorMessages))
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-medium">{{ $errorTitle }}</span>
                        <ul class="mt-1.5 list-disc list-inside">
                            @foreach ($errorMessages as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif



            <flux:input label="Nama Depan" placeholder="Contoh: Budi" wire:model.defer="first_name"/>
            <flux:input label="Nama Belakang" placeholder="Contoh: Santoso" wire:model.defer="last_name"/>
            <flux:input label="Email" type="email" placeholder="contoh@email.com" wire:model.defer="email"/>
            <flux:input label="Kata Sandi" type="password" placeholder="Minimal 8 karakter"
                        wire:model.defer="password"/>

            <flux:switch wire:model.live="is_superadmin"
                         label="Super Admin"
                         description="Pengguna ini memiliki akses penuh ke seluruh sistem."/>

            <div class="flex">
                <flux:spacer/>
                <flux:button wire:click="addUser" variant="primary">Simpan</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

