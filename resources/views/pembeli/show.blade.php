@extends('dashboard.layouts.mains')
@section('admin-magang')
<div class="container mt-4">
    <div class="card" style="max-width: 800px; margin: auto;">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Detail Pembeli: {{ $pembeli->name }}</h3>
            <a href="{{ route('pembeli.index') }}" class="btn btn-sm btn-danger"><span
                    data-feather="arrow-right"></span></a>
        </div>
        <div class="card-body">
            <div class="row mb-3 mt-3">
                <div class="col-md-12 text-center">

                    {{-- <img src="{{ url('pembeli-images/'.$pembeli->gambar) }}" width="100" height="100" alt="User Image" style="float: left; margin-right: 10px;"> --}}
                    <img class="rounded-circle"
                    src="{{ $pembeli->gambar ? asset('pembeli-images/' . $pembeli->gambar) : asset('images/bbb/default_profil.WEBP') }}"
                    alt="User Image" width="100" height="100" style="float: left; margin-right: 10px;">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>ID Pembeli:</strong></div>
                <div class="col-md-8">{{ $pembeli->id }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Nama Pembeli:</strong></div>
                <div class="col-md-8">{{ $pembeli->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Email:</strong></div>
                <div class="col-md-8">{{ $pembeli->email }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>No Tlp:</strong></div>
                <div class="col-md-8">{{ $pembeli->no_tlp }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Alamat Pembeli:</strong></div>
                <div class="col-md-8">{{ $pembeli->alamat_pembeli }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
