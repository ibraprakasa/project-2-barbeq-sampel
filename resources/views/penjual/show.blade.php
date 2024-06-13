@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="container mt-4">
        <div class="card" style="max-width: 800px; margin: auto;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Detail Penjual: {{ $user->name }}</h3>
                <a href="{{ route('penjual.index') }}" class="btn btn-sm btn-danger"><span
                        data-feather="arrow-right"></span></a>
            </div>

            <div class="card-body">
                <div class="row mb-3 mt-3">
                    <div class="col-md-12 text-center">
                        {{-- <img src="{{ $user->gambar }}" style="max-height: 300px" class="img-fluid mt-2" alt="{{ $user->name }}"> --}}
                        <img src="{{ url('user-images/' . $user->gambar) }}" width="100" height="100" alt="User Image"
                            style="float: left; margin-right: 10px;">
                    </div>

                </div>


                <div class="row mb-3">
                    <div class="col-md-4"><strong>ID user:</strong></div>
                    <div class="col-md-8">{{ $user->id }}</div>
                </div>


                <div class="row mb-3">
                    <div class="col-md-4"><strong>Total Pendapatan:</strong></div>
                    <div class="col-md-8">Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nama Penjual:</strong></div>
                    <div class="col-md-8">{{ $user->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Email:</strong></div>
                    <div class="col-md-8">{{ $user->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>No Tlp:</strong></div>
                    <div class="col-md-8">{{ $user->no_tlp }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Alamat Pembeli:</strong></div>
                    <div class="col-md-8">{{ $user->alamat }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
