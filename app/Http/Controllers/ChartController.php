<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        // Total laporan berdasarkan tipe
        $reportByType = Report::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        // Total laporan berdasarkan provinsi
        $reportByProvince = Report::select('province', DB::raw('count(*) as total'))
            ->groupBy('province')
            ->pluck('total', 'province');

        // Total laporan per bulan
        $reportByMonth = Report::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('hstaff.chart', compact('reportByType', 'reportByProvince', 'reportByMonth'));
    }
}
