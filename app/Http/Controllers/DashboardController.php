<?php

namespace App\Http\Controllers;

use App\Models\DebitCredit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $debit = DebitCredit::whereMonth('date_created', Carbon::now()->month)->where('debit_id', '!=', null)->sum('amount');
        $credit = DebitCredit::whereMonth('date_created', Carbon::now()->month)->where('credit_id', '!=', null)->sum('amount');
        $balanceThisMonth = $debit - $credit;

        $debitPerweek = DebitCredit::whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('debit_id', '!=', null)->sum('amount');
        $creditPerweek = DebitCredit::whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('credit_id', '!=', null)->sum('amount');
        $balanceTotalThisWeek = $debitPerweek - $creditPerweek;

        $debitCash = DebitCredit::where('method', 1)->whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('debit_id', '!=', null)->sum('amount');
        $creditCash = DebitCredit::where('method', 1)->whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('credit_id', '!=', null)->sum('amount');
        $balanceCashThisweek = $debitCash - $creditCash;

        $debitTrf = DebitCredit::where('method', 2)->whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('debit_id', '!=', null)->sum('amount');
        $creditTrf = DebitCredit::where('method', 2)->whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('credit_id', '!=', null)->sum('amount');
        $balanceTrfThisweek = $debitTrf - $creditTrf;

        return view('pages.dashboard.index', [
            'balanceThisMonth' => $balanceThisMonth,
            'debitPerweek' => $debitPerweek,
            'creditPerweek' => $creditPerweek,
            'balanceCashThisWeek' => $balanceCashThisweek,
            'balanceTrfThisWeek' => $balanceTrfThisweek,
            'balanceTotalThisWeek' => $balanceTotalThisWeek
        ]);
    }
}
