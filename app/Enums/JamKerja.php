<?php

namespace App\Enums;

enum JamKerja: string
{
    case TAHUN = 'tahun';
    case BULAN = 'bulan';
    case MINGGU = 'minggu';
    case HARI = 'hari';

    public function deskripsi(): string
    {
        return match ($this) {
            self::TAHUN => 'Total jumlah jam kerja yang tersedia dalam satu tahun',
            self::BULAN => 'Total jumlah jam kerja yang tersedia dalam satu Bulan',
            self::MINGGU => 'Total jumlah jam kerja yang tersedia dalam satu minggu',
            self::HARI => 'Total jumlah jam kerja yang tersedia dalam satu hari',
        };
    }

    public function totalJam(): float
    {
        return match ($this) {
            self::TAHUN => 2229,
            self::BULAN => 186,
            self::MINGGU => 46,
            self::HARI => 6.634,
        };
    }

    public static function toSelectOptions(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->deskripsi(),
            'jam' => $case->totalJam(),
        ], self::cases());
    }
}
