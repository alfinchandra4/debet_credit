@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <div class="col-md-8">
        <form action="{{ route('category-store') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Masukkan kategori" name="name">
                <span class="input-group-text" id="basic-addon1">
                    <input type="color" name="color" id="color">
                </span>
                <button class="btn btn-secondary" type="submit" id="button-addon2">Tambah</button>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Warna</th>
                            {{-- <th></th>   --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $cat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cat->name }}</td>
                            <td>
                                <div style="background: {{ $cat->color }}; height:30px; width:80px; "></div>
                            </td>
                            {{-- <td>
                                <a href="{{ route('category-delete', $cat->id) }}" class="btn btn-danger">Hapus</a>
                                <a href="{{ route('category-update', $cat->id) }}" class="btn btn-danger">Ubah</a>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
{{--  --}}
