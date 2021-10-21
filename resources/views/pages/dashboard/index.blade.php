@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
$debit = App\Models\DebitCredit::whereBetween('date_created', [Carbon\Carbon::now()->startOfWeek(),
Carbon\Carbon::now()->endOfWeek()])->where('debit_id', '!=', null)->sum('amount');
$credit = App\Models\DebitCredit::whereBetween('date_created', [Carbon\Carbon::now()->startOfWeek(),
Carbon\Carbon::now()->endOfWeek()])->where('credit_id', '!=', null)->sum('amount');
@endphp
<section class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon purple">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Saldo minggu ini</h6>
                                <h6 class="font-extrabold mb-0">Rp. {{ number_format($debit - $credit) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon blue">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Pemasukan</h6>
                                <h6 class="font-extrabold mb-0">Rp. {{ number_format($debit) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon green">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Pengeluaran</h6>
                                <h6 class="font-extrabold mb-0">Rp. {{ number_format($credit) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-primary">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon red">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-white font-semibold">Saldo bulan ini</h6>
                                <h6 class="text-white font-extrabold mb-0">Rp112</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">
        <table class="table" id="table1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php
                $report = App\Models\DebitCredit::whereBetween('date_created', [Carbon\Carbon::now()->startOfWeek(),
                Carbon\Carbon::now()->endOfWeek()])->get();
                $balance = 0;
                @endphp
                @foreach ($report as $data)
                @php
                if (!isset($data->debit_id)) {
                // Kredit ( dikurang )
                $balance-=($data->amount);
                $color = 'text-danger fw-bold';
                }

                if (!isset($data->credit_id)) {
                $balance+=($data->amount);
                $color = 'text-success fw-bold';
                }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d/m/Y', strtotime($data->date_created)) }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ !isset($data->debit_id) ? '-' : 'Rp. '.number_format($data->amount) }}</td>
                    <td>{{ !isset($data->credit_id) ? '-' : 'Rp. '.number_format($data->amount) }}</td>
                    <td class="{{ $color }}">Rp. {{ number_format($balance) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-primary text-white">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="fw-bold">Rp. {{ number_format($debit) }}</td>
                    <td class="fw-bold">Rp. {{ number_format($credit) }}</td>
                    <td class="fw-bold">Rp. {{ number_format($debit - $credit) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@section('js')
{{-- <script>
    // Jquery Datatable
    $(document).ready(function () {
        $.noConflict();
        var table = $('#table1').DataTable({
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(1)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(1, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(1).footer()).html(
                    '$' + pageTotal + ' ( $' + total + ' total)'
                );
            }
        });
    });

</script> --}}

@endsection
{{--  --}}
