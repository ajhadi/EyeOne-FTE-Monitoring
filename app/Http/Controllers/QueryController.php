<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function index(Request $request)
    {


// Ambil tanggal hari ini
        $today = Carbon::today();

// Ambil awal minggu (Senin)
        $startDate = $today->copy()->startOfWeek(Carbon::MONDAY);

// Ambil akhir minggu (Minggu)
        $endDate = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $selects = [
            'v.code',
        ];

// PA1 - PA7 (berdasarkan created_at)
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString();
            $selects[] = DB::raw("SUM(CASE WHEN DATE(pu.created_at) = '{$date}' THEN 1 ELSE 0 END) as PA" . ($i + 1));
        }

// Total Update Dispos
        $selects[] = DB::raw("SUM(CASE WHEN DATE(pu.created_at) BETWEEN '{$startDate->toDateString()}' AND '{$endDate->toDateString()}' THEN 1 ELSE 0 END) as total_update_dispos");

// Month & Week info
        $selects[] = DB::raw("MONTH('{$startDate->toDateString()}') as month_number");
        $selects[] = DB::raw("WEEK('{$startDate->toDateString()}') as week_number");
        $selects[] = DB::raw("'{$startDate->toDateString()}' as start_date_week");
        $selects[] = DB::raw("'{$endDate->toDateString()}' as end_date_week");

// Day1 - Day7 (berdasarkan pu.date)
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString();
            $selects[] = DB::raw("SUM(CASE WHEN pu.date = '{$date}' THEN 1 ELSE 0 END) as Day" . ($i + 1));
        }

// Total Update
        $selects[] = DB::raw("SUM(CASE WHEN pu.date BETWEEN '{$startDate->toDateString()}' AND '{$endDate->toDateString()}' THEN 1 ELSE 0 END) as total_update");

// Query utama
        $data = DB::table('project_updates as pu')
            ->join('vendors as v', 'pu.vendor_id', '=', 'v.id')
            ->select($selects)
            ->whereBetween('pu.created_at', [$startDate, $endDate])
            ->groupBy('v.code')
            ->orderBy('v.code')
            ->get();

        return response()->json($data);
    }

    public function days(Request $request){
        // Ambil tanggal hari ini
        $today = Carbon::today();

// Ambil awal minggu (Senin)
        $startDate = $today->copy()->startOfWeek(Carbon::MONDAY);

// Ambil akhir minggu (Minggu)
        $endDate = $today->copy()->endOfWeek(Carbon::SUNDAY);


        $totalUpdate = Project::whereHas('projectUpdates', function($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]);
        })->count();

// Total project yang tidak ada update di minggu ini
        $totalNotUpdate = Project::whereDoesntHave('projectUpdates', function($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]);
        })->count();

        return response()->json(['totalUpdate' => $totalUpdate, 'totalNotUpdate' => $totalNotUpdate]);
    }
}
