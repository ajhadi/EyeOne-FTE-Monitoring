<?php

namespace App\Enums;

enum StatusPekerjaan: int
{
    case OPEN = 1;
    case SURVEY = 2;
    case FOC = 3;
    case TRACING = 4;
    case JOINTING = 5;
    case FOT = 6;
    case CLOSED = 7;

    public function parameter_orang(): float
    {
        return match ($this) {
            self::OPEN => 1,
            self::SURVEY => 2,
            self::TRACING => 1,
            self::JOINTING => 1,
            self::FOT => 1,
            default => 0,
        };
    }

    public function parameter_hitungan(): float
    {
        return match ($this) {
            self::OPEN => 1,
            self::SURVEY => 3,
            self::TRACING => 1,
            self::JOINTING => 2,
            self::FOT => 2,
            self::FOC => 2,
            default => 0,
        };
    }

    public function parameter_khs(): float
    {
        return match ($this) {
            self::OPEN => 1.0,
            self::SURVEY => 3.0,
            self::FOC => 1.0,
            self::TRACING => 0.5,
            self::JOINTING => 2.0,
            self::FOT => 2.0,
            default => 0.0,
        };
    }


    public function description(): string
    {
        return match ($this) {
            self::OPEN => 'open',
            self::SURVEY => 'survey',
            self::FOC => 'foc',
            self::TRACING => 'tracing',
            self::JOINTING => 'jointing',
            self::FOT => 'fot',
            self::CLOSED => 'closed',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::OPEN => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            self::SURVEY => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            self::FOC => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            self::TRACING => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            self::JOINTING => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            self::FOT => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            self::CLOSED => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
        };
    }


    public static function toSelectOptions(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->description(),
        ], self::cases());
    }

    public static function toSelectOptionsV2(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [
                $case->value => $case->description(),
            ])
            ->toArray();
    }
}
