<?php

namespace App\Enums;

enum TipeKendala: int
{
    case BELUM_ADA_VENDOR_KHS = 1;
    case BENCANA_ALAM = 2;
    case KENDALA_USER = 3;
    case KESIAPAN_POP_BANDWIDTH = 4;
    case KESIAPAN_POP_PERANGKAT = 5;
    case KONFIRMASI_RAB_BESAR = 6;
    case KONFIRMASI_SCOPE_LAYANAN = 7;
    case LAYANAN_TIDAK_STANDAR = 8;
    case MATERIAL_FOT = 9;
    case MENUNGGU_KONFIGURASI = 10;
    case MENUNGGU_LASTMILE_SISI_LAIN = 11;
    case PENGADAAN_JASA_SPP = 12;
    case PENGADAAN_MATERIAL_FOC_FOT = 13;
    case PENGIRIMAN_VSAT = 14;
    case PERIJINAN_INDOOR = 15;
    case PERIJINAN_SOSIAL = 16;
    case PERIJINAN_OUTDOOR = 17;
    case PERIJINAN_USER = 18;
    case PERMIT_POP = 19;
    case PIHAK_KETIGA_SPP = 20;
    case POP_BELUM_READY = 21;
    case POP_BELUM_SUPPORT_SERVICE = 22;
    case PTL_REGIONAL = 23;
    case SPACE_POP_PENUH = 24;
    case SPACE_RACK_PENUH = 25;
    case TIDAK_ADA_KENDALA = 26;
    case TIDAK_ADA_ROW = 27;
    case TRACING_CORE = 28;
    case UPGRADE_POP = 29;
    case VENDOR_TERBATAS = 30;
    case DONE_BAI_BELUM_CLOSE = 31;
    case ORI_BELUM_CLOSE = 32;
    case PROPOSE_CANCEL = 33;
    case CLOSED = 34;
    case CANCELLED = 35;
    case TIDAK_UPDATE_WAG = 36;
    case UPDATE_TIDAK_SESUAI = 40;

    public function description(): string
    {
        return match ($this) {
            self::BELUM_ADA_VENDOR_KHS => 'Belum Ada vendor KHS',
            self::BENCANA_ALAM => 'Bencana Alam',
            self::KENDALA_USER => 'Kendala User',
            self::KESIAPAN_POP_BANDWIDTH => 'Kesiapan POP (bandwidth)',
            self::KESIAPAN_POP_PERANGKAT => 'Kesiapan POP (perangkat distribusi)',
            self::KONFIRMASI_RAB_BESAR => 'Konfirmasi Nilai RAB Besar',
            self::KONFIRMASI_SCOPE_LAYANAN => 'Konfirmasi Scope Layanan (Sales Confirmation)',
            self::LAYANAN_TIDAK_STANDAR => 'Layanan Tidak Standar',
            self::MATERIAL_FOT => 'Material FOT',
            self::MENUNGGU_KONFIGURASI => 'Menunggu Konfigurasi',
            self::MENUNGGU_LASTMILE_SISI_LAIN => 'Menunggu Proses Lastmile Sisi Lain',
            self::PENGADAAN_JASA_SPP => 'Pengadaan Jasa Pihak Ketiga (SPP)',
            self::PENGADAAN_MATERIAL_FOC_FOT => 'Pengadaan material FOC dan FOT',
            self::PENGIRIMAN_VSAT => 'Pengiriman Material VSAT',
            self::PERIJINAN_INDOOR => 'Perijinan Indoor',
            self::PERIJINAN_SOSIAL => 'Perijinan Sosial',
            self::PERIJINAN_OUTDOOR => 'Perijinan Tarikan Outdoor',
            self::PERIJINAN_USER => 'Perijinan User',
            self::PERMIT_POP => 'Permit POP',
            self::PIHAK_KETIGA_SPP => 'Pihak Ketiga (sudah SPP)',
            self::POP_BELUM_READY => 'POP Belum Ready (POP/PS POP/FOC POP belum ada)',
            self::POP_BELUM_SUPPORT_SERVICE => 'POP Belum Support Service (QnQ, License, modul)',
            self::PTL_REGIONAL => 'PTL Regional',
            self::SPACE_POP_PENUH => 'Space POP Penuh (Lahan, Non Rack)',
            self::SPACE_RACK_PENUH => 'Space Rack Penuh (POP)',
            self::TIDAK_ADA_KENDALA => 'tidak ada kendala',
            self::TIDAK_ADA_ROW => 'Tidak Ada RoW',
            self::TRACING_CORE => 'Tracing Core',
            self::UPGRADE_POP => 'Upgrade POP (PS, Andop)',
            self::VENDOR_TERBATAS => 'Vendor Terbatas (Kurang Tim)',
            self::DONE_BAI_BELUM_CLOSE => 'done BAI testcomm, belum di close',
            self::ORI_BELUM_CLOSE => 'ori tidak ada pekerjaan, belum di close',
            self::PROPOSE_CANCEL => 'propose cancel',
            self::CLOSED => 'CLOSED',
            self::CANCELLED => 'CANCELLED',
            self::TIDAK_UPDATE_WAG => 'Tidak Update WAG',
            self::UPDATE_TIDAK_SESUAI => 'Update tidak sesuai (6-11-22)',
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
