<?php

namespace App\Services\Earnings;

use Illuminate\Support\Facades\DB;

class EarningsService
{
    public function getMonthlyEarnings($year,$month)
    {
        $earnings = DB::table('payments')
            ->select(
                DB::raw('SUM(amount) as total_earnings')
            )
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        return $earnings;
    }

    public function getDaybyDayEarnings($year,$month)
    {
        $earnings = DB::table('payments')
            ->select(
                DB::raw('DATE(created_at) as daty'), // Extraire le jour
                DB::raw('SUM(amount) as total_earnings') // Somme des montants
            )
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy(DB::raw('DATE(created_at)')) // Regrouper par jour
            ->orderBy('daty')
            ->get();

        return $earnings;
    }

    public function getAnnualEarnings($year)
    {
        $earnings = DB::table('payments')
            ->select(
                DB::raw('SUM(amount) as total_earnings')
            )
            ->whereYear('created_at', $year)
            ->get();

        return $earnings;
    }
}