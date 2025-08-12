<?php

namespace App\Livewire\Forms;

use App\Models\Vendor;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VendorEditForm extends Form
{
    #[Validate('required|string|min:2')]
    public $code = '';

    #[Validate('required|string|min:3')]
    public $name = '';

    #[Validate('nullable|string|min:5')]
    public $address = '';

    #[Validate('nullable|string|min:8')]
    public $phone = '';

    #[Validate('required|string')]
    public $zone = '';

    #[Validate('required|integer|min:1')]
    public $team_count = 1;

    #[Validate('required|integer|min:1')]
    public $members_per_team = 1;

    public function fillFromVendor(Vendor $vendor): void
    {
        $this->code = $vendor->code;
        $this->name = $vendor->name;
        $this->address = $vendor->address;
        $this->phone = $vendor->phone;
        $this->zone = $vendor->zone;
        $this->team_count = $vendor->team_count;
        $this->members_per_team = $vendor->members_per_team;
    }

    public function updateVendor(Vendor $vendor): void
    {
        $this->validate();

        $vendor->update([
            'code' => $this->code,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'zone' => $this->zone,
            'team_count' => $this->team_count,
            'members_per_team' => $this->members_per_team,
        ]);
    }
}
