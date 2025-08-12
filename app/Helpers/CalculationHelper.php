<?php

namespace App\Helpers;

use App\Enums\JamKerja;
use App\Enums\StatusPekerjaan;

class CalculationHelper
{
    public static function AnalisaFTE(array $vendor): array
    {
        $conHourOpen = $vendor['total_open']
            * ParameterKontanta::OPEN
            *  StatusPekerjaan::OPEN->parameter_hitungan()
            * JamKerja::HARI->totalJam();

        $conHourSurvey = $vendor['total_open']
            * ParameterKontanta::TIM_SURVEY
            *  StatusPekerjaan::SURVEY->parameter_hitungan()
            * JamKerja::HARI->totalJam();

        $conHourAmbilMaterial = ($vendor['total_survey']
                + $vendor['total_foc']
                + $vendor['total_tracing']
                + $vendor['total_fot'])
            * ParameterKontanta::AMBIL_MATERIAL
            * 2
            * StatusPekerjaan::OPEN->parameter_hitungan()
            * JamKerja::HARI->totalJam();

        $conHourFOC = ($vendor['remaining_pull'] / 1000)
            * ParameterKontanta::TIM_STRINGER
            * StatusPekerjaan::FOC->parameter_hitungan()
            * JamKerja::HARI->totalJam();

        $conHourJointing = ($vendor['total_survey']
                + $vendor['total_foc']
                + $vendor['total_tracing'])
            * ParameterKontanta::TIM_JOINTING
            * StatusPekerjaan::JOINTING->parameter_hitungan()
            * JamKerja::HARI->totalJam();

        $conHourTracing = ($vendor['remaining_tracing'] / 2000)
            * ParameterKontanta::TIM_TRACING
            *  StatusPekerjaan::TRACING->parameter_hitungan()
            * JamKerja::HARI->totalJam();

        $conHourFOT = ($vendor['total_survey']
                + $vendor['total_foc']
                + $vendor['total_tracing']
                + $vendor['total_fot'])
            * ParameterKontanta::TIM_FOT
            * StatusPekerjaan::FOT->parameter_hitungan()
            * JamKerja::HARI->totalJam();

        $total = round($conHourOpen)
            + round($conHourSurvey)
            + round($conHourAmbilMaterial)
            + round($conHourFOC)
            + round($conHourJointing)
            + round($conHourTracing)
            + round($conHourFOT);

//        if($vendor['id'] == 2)
//        {
//            dd(
//                $vendor,
//                round($conHourOpen),
//                round($conHourSurvey),
//                round($conHourAmbilMaterial),
//                round($conHourFOC),
//                round($conHourJointing),
//                round($conHourTracing),
//                round($conHourFOT)
//            );
//        }

        $hourPerWeeks =  JamKerja::MINGGU->totalJam() * $vendor['members_per_team'] *  $vendor['team_count'];
        $hourPerMonths =  JamKerja::BULAN->totalJam() * $vendor['members_per_team'] *  $vendor['team_count'];

        $indexWeeks = $total / $hourPerWeeks;
        $indexMonths = $total / $hourPerMonths;

        $weekAnalisa =  'MASA PESIAPAN';
        $monthAnalisa =  'MASA PESIAPAN';

        // Nilai patokan
        $g166 = 0.65;
        $g167 = 1.35;
        $g168 = 1.35; // sama dengan $g167


        // Cek sesuai urutan logika Excel
        if (!is_null($indexWeeks)) {
            if ($indexWeeks <= $g166) { // 0.036 <= 0.65 -> TRUE
                $weekAnalisa = "UNDERLOAD"; // Kode ini yang akan dieksekusi
            } elseif ($indexWeeks <= $g167) { // Ini tidak akan dicek
                $weekAnalisa = "FIT";
            } elseif ($indexWeeks > $g168) { // Ini juga tidak akan dicek
                $weekAnalisa = "OVERLOAD";
            }
        }

        if (!is_null($indexMonths)) {
            if ($indexMonths <= $g166) {
                $monthAnalisa = "UNDERLOAD";
            } elseif ($indexMonths <= $g167) {
                $monthAnalisa = "FIT";
            } elseif ($indexMonths > $g168) {
                $monthAnalisa = "OVERLOAD";
            }
        }

        $result = [
            'total' => $total,
            'week_index' => $indexWeeks,
            'week_analisa' => $weekAnalisa,
            'month_index' => $indexMonths,
            'month_analisa' => $monthAnalisa,
            'consumed_days' => round ($total / 8)
        ];

//        if($vendor['id'] == 2)
//        {
//            dd($result);
//        }
        return $result;
    }

}

class ParameterKontanta {
    const OPEN = 1;
    const AMBIL_MATERIAL = 1;
    const TIM_SURVEY = 2;
    const TIM_STRINGER = 3;
    const TIM_TRACING = 2;
    const TIM_JOINTING = 1;
    const TIM_FOT = 2;
    const KOORDINATOR = 1;
    const ADMIN_PROJECT = 1;
    const TOTAL = 12;
    const TOTAL_PARALEL = 7;
    const TOTAL_PARALEL_W_KOOR_ADM = 5;
    const TOTAL_PARALEL_SUB_TIM = 2;
}
