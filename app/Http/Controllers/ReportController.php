<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period', 'daily');

        if ($period === 'daily') {
            $visits = DB::table('registrations')
                ->select(DB::raw('DATE(registration_date) as date'), DB::raw('COUNT(*) as total'))
                ->where('registration_date', '>=', Carbon::now()->subDays(30))
                ->groupBy(DB::raw('DATE(registration_date)'))
                ->orderBy('date')
                ->get()
                ->map(function ($item) {
                    return [
                        'date' => Carbon::parse($item->date)->format('Y-m-d'),
                        'total' => $item->total,
                    ];
                });

            $labels = $visits->pluck('date')->toArray();
            $data = $visits->pluck('total')->toArray();
        } else {
            $visits = DB::table('registrations')
                ->select(DB::raw("TO_CHAR(registration_date, 'YYYY-MM') as month"), DB::raw('COUNT(*) as total'))
                ->where('registration_date', '>=', Carbon::now()->subMonths(12))
                ->groupBy(DB::raw("TO_CHAR(registration_date, 'YYYY-MM')"))
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => Carbon::createFromFormat('Y-m', $item->month)->format('F Y'),
                        'total' => $item->total,
                    ];
                });

            $labels = $visits->pluck('month')->toArray();
            $data = $visits->pluck('total')->toArray();
        }

        $labels = $labels ?: [];
        $data = $data ?: [];

        return view('reports.index', [
            'period' => $period,
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}