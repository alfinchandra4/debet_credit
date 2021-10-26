@extends('layouts.app')

@section('title', 'Pemasukan')

@section('content')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Tambah Pemasukan
</button>

<div class="card mt-4">
    <div class="card-body">
        <table class="table" id="table1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Via</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($debts as $debt)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d/m/y', strtotime($debt->date_created)) }}</td>
                    <td>{{ ucwords(strtolower($debt->description)) }}</td>
                    <td><span class='badge bg-primary'>{{ $debt->method == 1 ? "CASH" : "TRF" }}</span></td>
                    <th>
                        <span class="badge" style="background: {{ $debt->category->color }}">
                            {{ $debt->category->name }}
                        </span>
                    </th>
                    <td>Rp. {{ number_format($debt->amount) }}</td>
                    <th>
                        <a href="{{ route('debit-delete', $debt->id) }}" class="btn btn-danger btn-sm">Delete</a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal modal-borderless fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah pemasukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('debit-store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-5">
                            <label for="date_created">Tanggal</label>
                            <input type="date" class="form-control" id="datepicker" required name="date_created" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" id="category_id" class="form-select">
                                @php
                                $categories = App\Models\Category::orderByDesc('created_at')->get();
                                @endphp
                                @foreach ($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="method">Secara</label>
                            <select name="method" id="method" class="form-select">
                                <option value="1">Tunai</option>
                                <option value="2">Transfer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Jumlah</label>
                            <div class="input-group">
                                <span class="input-group-text" id="amount">Rp.</span>
                                <input type="text" class="form-control" id="amount" required name="amount">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <input type="text" class="form-control" id="description" required name="description">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        // show the alert
        setTimeout(function () {
            $(".alert").alert('close');
        }, 2500);
    });
</script>

<script>
    // Jquery Datatable
    let jquery_datatable = $("#table1").DataTable({
        "pageLength": 50,
        "order": [[ 0, "desc" ]],
    });

</script>
@endsection

{{--  --}}
