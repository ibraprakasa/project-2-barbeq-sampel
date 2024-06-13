@extends('dashboard.layouts.mains')
@section('admin-magang')
<div class="container mt-4">
    <div class="card" style="max-width: 800px; margin: auto;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Detail Produk: {{ $produk->nama_produk }}</h3>
            <a href="{{ route('produk.index') }}" class="btn btn-sm btn-danger"><span data-feather="arrow-right"></span></a>
        </div>

        <div class="card-body">
            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
            <div class="row mb-3">
                <div class="col-md-4"><strong>ID User:</strong></div>
                <div class="col-md-8">{{ $produk->user->id }}</div>
            </div>
            @endif
            <div class="row mb-3">
                <div class="col-md-4"><strong>ID Produk:</strong></div>
                <div class="col-md-8">{{ $produk->id }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Kode Produk:</strong></div>
                <div class="col-md-8">{{ $produk->kode }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Nama Produk:</strong></div>
                <div class="col-md-8">{{ $produk->nama_produk }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Harga:</strong></div>
                <div class="col-md-8">{{ $produk->harga }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Stock:</strong></div>
                <div class="col-md-8">{{ $produk->stock }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Detail:</strong></div>
                <div class="col-md-8">{{ $produk->detail }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Kategori:</strong></div>
                <div class="col-md-8">{{ $produk->kategori->kategori }}</div>
            </div>
            {{-- <div class="row mb-3">
                <div class="col-md-4"><strong>Penjual:</strong></div>
                <div class="col-md-8">{{ $produk->user->name }}</div>
            </div> --}}
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <img src="{{ $produk->gambar }}" style="max-height: 300px" class="img-fluid mt-2" alt="{{ $produk->nama_produk }}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
