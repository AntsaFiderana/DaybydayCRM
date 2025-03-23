<?php

namespace App\Services\Earnings;

use App\Repositories\Money\Money;
use App\Repositories\Money\MoneyConverter;
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
            ->first();
        $earning=$earnings && $earnings->total_earnings !== null ? $earnings->total_earnings : 0;

        return app(MoneyConverter::class, ['money' => new Money($earning)])->format();
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
            ->first();
        $earning=$earnings && $earnings->total_earnings !== null ? $earnings->total_earnings : 0;

        return app(MoneyConverter::class, ['money' => new Money($earning)])->format();
    }
}