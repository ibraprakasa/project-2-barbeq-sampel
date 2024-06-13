@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="container mt-4">
        <div class="card" style="max-width: 800px; margin: auto;">

            <div class="card-header d-flex justify-content-end align-items-center">
                <a href="{{ route('pesanan.index') }}" class="btn btn-sm btn-danger"><span
                        data-feather="arrow-right"></span></a>
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4 mt-4">
                        <strong>
                            Bukti Pembayaran
                        </strong>
                    </div>
                    <div class="col-md-4 mt-4">
                        @if (optional($pesanan->gambar)->exists())
                            <img src="{{ asset($pesanan->gambar) }}" alt="" width="200" height="150"
                                alt="User Image" style="float: left; margin-center: 10px;">
                        @else
                            pembeli belum bayar
                        @endif
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <div class="col-md-4"><strong>ID Pesanan:</strong></div>
                    <div class="col-md-8">{{ $pesanan->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Expedisi:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->expedisi)->expedisi }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Cara Bayar:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->bayar)->cara_bayar }}</div>
                </div>

                @if ($pesanan && $pesanan->bayar_id != 0 && $pesanan->bayar_id != 1 && $pesanan->statusverifikasi)
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Status:</strong></div>
                        <div class="col-md-8">{{ optional($pesanan->statusverifikasi)->statusverifikasi }}</div>
                    </div>
                @else

                @endif


                @can('admin')
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Penjual:</strong></div>
                        <div class="col-md-8">{{ optional($pesanan->user)->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>No tlp Penjual:</strong></div>
                        <div class="col-md-8">{{ optional($pesanan->user)->no_tlp }}</div>
                    </div>
                @endcan
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Pembeli:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->pembeli)->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>No tlp Pembeli:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->pembeli)->no_tlp }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Alamat Pembeli:</strong></div>
                    <div class="col-md-8">{{ $pesanan->alamat }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nama Produk:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->produk)->nama_produk }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Jumlah Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->jumlah_produk }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Harga:</strong></div>
                    <div class="col-md-8">{{ $pesanan->harga }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>ID Produk:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->produk)->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Kode Produk:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->produk)->kode }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Kategori:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->produk->kategori)->kategori }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
