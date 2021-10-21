<?php

namespace App\Http\Controllers;

use App\Models\DebitCredit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index() {
        return view('pages.history.index');
    }

    public function check(Request $request) {
        // dd($request->all());
        if ($request->report == null) {
        }
        switch ($request->report) {
            case 'period':
                    return $this->period($request->all());
                break;

            case 'month':
                    return $this->month($request->month);
                break;

            case 'simple':
                    return $this->simple($request->all());
                break;

            case null:
                return back()->withError('Silahkan pilih opsi periode');
                break;

        }
    }

    public function simple($data) {

        Carbon::setLocale('id');

        switch ($data['option']) {
            case 'week':
                $debitCredit = DebitCredit::whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
                $debit = DebitCredit::whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('debit_id', '!=', null)->sum('amount');
                $credit = DebitCredit::whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('credit_id', '!=', null)->sum('amount');
                return view('pages.history.index', [
                    'period' => $debitCredit,
                    'debit' => $debit,
                    'credit' => $credit,
                    'report_mode' => 'simple',
                    'option_mode' => 'week'
                ]);
                break;

            case 'month':
                $debitCredit = DebitCredit::whereMonth('date_created', Carbon::now()->month)->get();
                $debit = DebitCredit::whereMonth('date_created', Carbon::now()->month)->where('debit_id', '!=', null)->sum('amount');
                $credit = DebitCredit::whereMonth('date_created', Carbon::now()->month)->where('credit_id', '!=', null)->sum('amount');
                return view('pages.history.index', [
                    'period' => $debitCredit,
                    'debit' => $debit,
                    'credit' => $credit,
                    'report_mode' => 'simple',
                    'option_mode' => 'month'
                ]);
                break;

            default:
                # code...
                break;
        }
    }

    public function period($data) {
        $start_date = date('Y-m-d', strtotime($data['start_date']));
        $end_date = date('Y-m-d', strtotime($data['end_date']));
        $debitCredit = DebitCredit::whereBetween('date_created', [$start_date, $end_date])->get();
        $debit = DebitCredit::whereBetween('date_created', [$start_date, $end_date])->where('debit_id', '!=', null)->sum('amount');
        $credit = DebitCredit::whereBetween('date_created', [$start_date, $end_date])->where('credit_id', '!=', null)->sum('amount');
        return view('pages.history.index', [
            'period' => $debitCredit,
            'debit' => $debit,
            'credit' => $credit,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'report_mode' => 'period'
        ]);
    }

    public function month($month) {
        $debitCredit = DebitCredit::whereMonth('date_created', $month)->whereYear('date_created', date('Y'))->get();
        $debit = DebitCredit::whereMonth('date_created', $month)->whereYear('date_created', date('Y'))->where('debit_id', '!=', null)->sum('amount');
        $credit = DebitCredit::whereMonth('date_created', $month)->whereYear('date_created', date('Y'))->where('credit_id', '!=', null)->sum('amount');
        return view('pages.history.index', [
            'period' => $debitCredit,
            'debit' => $debit,
            'credit' => $credit,
            'report_mode' => 'month',
            'month_numeric' => $month
        ]);
    }



}
