@extends('layouts.app')

@section('title', 'Riwayat keuangan')

@section('content')
<div class="card col-md-8">
    <div class="card-body">
        <h5 class="fw-light">Pilih periode:</h5>
        <form action="{{ route('history-check') }}" method="post">
            @csrf
            <table class="table">
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="report" id="report" value="period"
                                checked>
                            <label class="form-check-label" for="report">
                                Periode transaksi dari:
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control" name="start_date" id="datepicker"
                                value="{{ isset($start_date) ? date('m/d/Y', strtotime($start_date)) : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Ke</span>
                            </div>
                            <input type="text" class="form-control" name="end_date" id="datepicker1"
                                value="{{ isset($end_date) ? date('m/d/Y', strtotime($end_date)) : '' }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="report" id="report1" value="month"
                                {{ isset($report_mode) && $report_mode == 'month' ? 'checked' : ''}}>
                            <label class="form-check-label" for="report1">
                                Periode bulan:
                            </label>
                        </div>
                    </td>
                    <td>
                        @php
                        $months = ["Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                        "September", "Oktober", "November", "Desember"];
                        @endphp
                        <select name="month" id="month" class="form-select">
                            @foreach ($months as $key => $month)
                            @php
                            $month_key = str_pad($key+1, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <option value={{ $month_key }}
                                {{ isset($month_numeric) && $month_key == $month_numeric ? 'selected' : '' }}>
                                {{ $month }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="report" id="report2" value="simple"
                                {{ isset($report_mode) && $report_mode == 'simple' ? 'checked' : ''}}>
                            <label class="form-check-label" for="report2">
                                Berdasarkan:
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="option" id="option" value="week"
                                {{ isset($option_mode) && $option_mode == 'week' ? 'checked' : ''}}>
                            <label class="form-check-label" for="option">
                                Minggu ini
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="option" id="option1" value="month"
                                {{ isset($option_mode) && $option_mode == 'month' ? 'checked' : ''}}>
                            <label class="form-check-label" for="option1">
                                Bulan ini
                            </label>
                        </div>
                    </td>
                </tr>
            </table>
            <div style="float: right">
                <a href="{{ route('history') }}" class="btn btn-outline-secondary">Reset</a>
                <button type="submit" class="btn btn-primary">Lihat Riwayat</button>
            </div>
        </form>
    </div>
</div>

@isset($period)
<div class="card">
    <div class="card-body">
        <table class="table">
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
                $balance = 0;
                @endphp
                @foreach ($period as $data)
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
                    <td class="{{ $color }}">Rp. {{number_format($balance) }}</td>
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
@endisset

@endsection

@section('js')
<script>
    $(function () {
        $("#datepicker").datepicker();
    });

    $(function () {
        $("#datepicker1").datepicker();
    });

</script>
<script>
    $(document).ready(function () {
        console.log('ok');
        // show the alert
        setTimeout(function () {
            $(".alert").alert('close');
        }, 2500);
    });

</script>
@endsection
