@extends('layouts.app')

@section('title', 'Pengeluaran')

@section('content')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Tambah pengeluaran
</button>

<div class="card mt-4">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($credits as $credit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d/m/y', strtotime($credit->date_created)) }}</td>
                    <td>{{ $credit->description }}</td>
                    <td>Rp. {{ number_format($credit->amount) }}</td>
                    <th>
                        <span class="badge bg-light-primary">
                            {{ $credit->category->name }}
                        </span>
                    </th>
                    <th>
                        <a href="{{ route('credit-delete', $credit->id) }}" class="btn btn-danger btn-sm">Delete</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('credit-store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <input type="text" class="form-control" id="description" required name="description">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="date_created">Tanggal</label>
                            <input type="date" class="form-control" id="datepicker" required name="date_created"
                                value="{{ date('Y-m-d') }}">
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
                            <label for="amount">Jumlah</label>
                            <div class="input-group">
                                <span class="input-group-text" id="amount">Rp.</span>
                                <input type="text" class="form-control" id="amount" required name="amount">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
{{-- <script>
    $(function () {
        $("#datepicker").datepicker();
    });
</script> --}}
@endsection

{{--  --}}
