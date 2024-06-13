@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="container mt-4">
        <div class="card" style="max-width: 800px; margin: auto;">
            <div class="card-header d-flex justify-content-end align-items-center">
                <a href="{{ route('all.index') }}" class="btn btn-sm btn-danger">
                    <span data-feather="arrow-right"></span>
                </a>
            </div>
            <div class="card-body">

                <div class="row mb-3 mt-3">
                    <div class="col-md-4"><strong>ID Pesanan:</strong></div>
                    <div class="col-md-8">{{ $pesanan->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Cara Bayar:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->bayar)->cara_bayar }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Expedisi:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->expedisi)->expedisi }}</div>
                </div>

                @if ($pesanan && $pesanan->bayar_id >= 2 && $pesanan->statusverifikasi)
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Status:</strong></div>
                        <div class="col-md-8">{{ optional($pesanan->statusverifikasi)->statusverifikasi }}</div>
                    </div>
                @else
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Status:</strong></div>
                        <div class="col-md-8">tidak perlu status verifikasi dikarenakan pembayaran COD.</div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Status Pengiriman:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->status)->status }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nama Produk:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->produk)->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>No tlp Penjual:</strong></div>
                    <div class="col-md-8">{{ optional($pesanan->user)->no_tlp }}</div>
                </div>
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


                <div class="row mb-3">
                    <div class="col-md-4 mt-4">
                        <strong>
                            Bukti Pembayaran
                        </strong>
                    </div>
                    <div class="col-md-4 mt-4">
                        @if ($pesanan->gambar)
                            <img src="{{ asset($pesanan->gambar) }}" alt="" width="200" height="150"
                                alt="User Image" style="float: left; margin-center: 10px;">
                        @else
                            pembeli belum bayar
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 mt-4">

                        <strong>
                            @if (auth()->user()->isadmin)
                                Bukti Setor
                            @else
                                Bukti Pemasukan/TF dari Admin
                            @endif
                        </strong>
                    </div>
                    <div class="col-md-4 mt-4">
                        @if ($pesanan->gambar2)
                            <img src="{{ asset($pesanan->gambar2) }}" alt="" width="200" height="150"
                                alt="User Image" style="float: left; margin-center: 10px;">
                        @else
                            belum ada setor
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
