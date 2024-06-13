@extends('dashboard.layouts.mains')
@section('admin-magang')
<div class="container mt-4">
    <div class="card" style="max-width: 800px; margin: auto;">
        <div class="card-header d-flex justify-content-end align-items-center">
            <a href="{{ route('pengiriman.index') }}" class="btn btn-sm btn-danger"><span
                    data-feather="arrow-right"></span></a>
        </div>
        <div class="card-body">
            <div class="row mb-3 mt-3">
                <div class="col-md-4"><strong>ID Pesanan:</strong></div>
                <div class="col-md-8">{{ $pesanan->id }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mt-4">
                    <strong>
                        Resi
                    </strong>
                </div>
                <div class="col-md-4 mt-4">
                    @if ($pesanan->gambar3)
                        <img src="{{ asset($pesanan->gambar3) }}" alt="" width="200" height="150"
                            alt="User Image" style="float: left; margin-center: 10px;">
                    @else
                         belum ada resi pengiriman
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Expedisi:</strong></div>
                <div class="col-md-8">{{ $pesanan->expedisi->expedisi }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Cara bayar:</strong></div>
                <div class="col-md-8">{{ $pesanan->bayar->cara_bayar }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Status Pengiriman:</strong></div>
                <div class="col-md-8">{{ $pesanan->status->status }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4"><strong>Penjual:</strong></div>
                <div class="col-md-8">{{ $pesanan->user->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>No tlp Penjual:</strong></div>
                <div class="col-md-8">{{ $pesanan->user->no_tlp }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Pembeli:</strong></div>
                <div class="col-md-8">{{ $pesanan->pembeli->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>No tlp Pembeli:</strong></div>
                <div class="col-md-8">{{ $pesanan->pembeli->no_tlp }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Alamat Pembeli:</strong></div>
                <div class="col-md-8">{{ $pesanan->alamat }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Nama Produk:</strong></div>
                <div class="col-md-8">{{ $pesanan->produk->nama_produk }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Jumlah Produk:</strong></div>
                <div class="col-md-8">{{ $pesanan->jumlah_produk }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Harga:</strong></div>
                <div class="col-md-8">{{ $pesanan->harga }}</div>
            </div>
            {{-- <div class="row mb-3">
                <div class="col-md-4"><strong>Cara Bayar:</strong></div>
                <div class="col-md-8">{{ $pesanan->bayar->cara_bayar }}</div>
             </div> --}}
            {{-- <div class="row mb-3">
                <div class="col-md-4"><strong>ID Produk:</strong></div>
                <div class="col-md-8">{{ $pesanan->produk->id }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Kode Produk:</strong></div>
                <div class="col-md-
                8">{{ $pesanan->produk->kode }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Kategori:</strong></div>
                <div class="col-md-8">{{ $pesanan->produk->kategori->kategori }}</div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
