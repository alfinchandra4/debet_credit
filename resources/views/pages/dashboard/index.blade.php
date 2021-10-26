@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="stats-icon purple">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h6 class="text-muted font-semibold">Saldo CASH minggu ini</h6>
                                <h6 class="font-extrabold mb-0">Rp. {{ number_format($balanceCashThisWeek) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="stats-icon blue">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h6 class="text-muted font-semibold">Pemasukan minggu ini</h6>
                                <h6 class="font-extrabold mb-0">Rp. {{ number_format($debitPerweek) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="stats-icon green">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h6 class="text-muted font-semibold">Pengeluaran minggu ini</h6>
                                <h6 class="font-extrabold mb-0">Rp. {{ number_format($creditPerweek) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card bg-primary">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="stats-icon red">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h6 class="text-white font-semibold">Saldo bulan ini</h6>
                                <h6 class="text-white font-extrabold mb-0">Rp. {{ number_format($balanceThisMonth) }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="stats-icon purple">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h6 class="text-muted font-semibold">Saldo Transfer minggu ini</h6>
                                <h6 class="font-extrabold mb-0">Rp. {{ number_format($balanceTrfThisWeek) }}</h6>
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
                    <th>Via</th>
                    <th>Kategori</th>
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
                    <td>{{ ucwords(strtolower($data->description)) }}</td>
                    <td><span class='badge bg-primary'>{{ $data->method == 1 ? "CASH" : "TRF" }}</span></td>
                    <td>
                        <span class="badge" style="background: {{ $data->category->color }}">
                            {{ $data->category->name }}
                        </span>
                    </td>
                    {{-- <td>{{ !isset($data->debit_id) ? '-' : 'Rp. '.number_format($data->amount) }}</td> --}}
                    <td>{{ !isset($data->debit_id) ? 0 : $data->amount }}</td>
                    {{-- <td>{{ !isset($data->credit_id) ? '-' : 'Rp. '.number_format($data->amount) }}</td> --}}
                    <td>{{ !isset($data->credit_id) ? 0 : $data->amount }}</td>
                    <td class="{{ $color }}">Rp. {{ number_format($balance) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-primary text-white">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@section('js')

<script>
    function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

    let ex = document.querySelector('tbody').rows;
    for (let i = 0; i < ex.length; i++) {
        ex[i].cells[5].innerText = numberWithCommas(ex[i].cells[5].innerText);
        // ex[i].innerText = numberWithCommas(ex[i].cells[5].innerText);
    }
</script>

<script>
    // Jquery Datatable
    let jquery_datatable = $("#table1").
    DataTable({
        "pageLength": 50,
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

            // DEBET
            // Total over all pages
            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(5, {
                    page: 'current'
                })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(5).footer()).html(
                numberWithCommas(pageTotal) + ' <br/> (' + numberWithCommas(total) + ')'
            );

            // CREDIT
            // Total over all pages
            totalCol6 = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotalCol6 = api
                .column(6, {
                    page: 'current'
                })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(6).footer()).html(
                numberWithCommas(pageTotalCol6) + ' <br/> (' + numberWithCommas(totalCol6) + ')'
            );

        }
    });

</script>

@endsection
{{--  --}}
