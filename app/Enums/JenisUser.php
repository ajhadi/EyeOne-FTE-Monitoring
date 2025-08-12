<?php

namespace App\Enums;

enum JenisUser: int
{
    case ADMINISTRATOR = 1;
    case MEMBER = 2;
    case VENDOR = 3;

    public function description(): string
    {
        return match ($this) {
            self::ADMINISTRATOR => 'Administrator',
            self::MEMBER => 'Member',
            self::VENDOR => 'Vendor',
        };
    }

    public static function toSelectOptions(): array
    {
        return array_values(array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->description(),
        ], array_filter(self::cases(), fn($case) => $case !== self::VENDOR)));
    }
}
