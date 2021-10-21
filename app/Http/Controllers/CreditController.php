<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\DebitCredit;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index() {
        $credits = Credit::all();
        return view('pages.credit.index', [
            'credits' => $credits
        ]);
    }

    public function store(Request $request) {
        Credit::create($request->all());
        $latest = Credit::latest()->first();
        $request->merge(["credit_id" => $latest->id]);
        $input = $request->except(['debit_id']);
        DebitCredit::create($input);
        return back()->withSuccess('Berhasil menambah pengeluaran');
    }

    public function delete($credit_id) {
        Credit::find($credit_id)->delete();
        DebitCredit::where('credit_id', $credit_id)->delete();
        return back()->withSuccess('Berhasil menambah pengeluaran');
    }
}
