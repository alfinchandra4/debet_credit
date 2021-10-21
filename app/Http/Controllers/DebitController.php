<?php

namespace App\Http\Controllers;

use App\Models\Debit;
use App\Models\DebitCredit;
use Illuminate\Http\Request;

class DebitController extends Controller
{
    public function index()
    {
        $debts = Debit::all();
        return view('pages.debit.index', [
            'debts' => $debts
        ]);
    }

    public function store(Request $request)
    {
        Debit::create($request->all());
        $latest = Debit::latest()->first();
        $request->merge(["debit_id" => $latest->id]);
        $input = $request->except(['credit_id']);
        DebitCredit::create($input);
        return back()->withSuccess('Berhasil menambah pemasukan');
    }

    public function delete($debit_id) {
        Debit::find($debit_id)->delete();
        DebitCredit::where('debit_id', $debit_id)->delete();
        return back()->withSuccess('Berhasil menghapus pemasukan');
    }
}
