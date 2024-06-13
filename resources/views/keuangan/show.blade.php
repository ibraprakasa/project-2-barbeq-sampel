@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="container mt-4">
        <div class="card" style="max-width: 800px; margin: auto;">

		<div class="card-header d-flex justify-content-end align-items-center">
            <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-danger"><span
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
                            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
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
                            tidak ada setor
                        @endif
                    </div>

                </div>


                @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                    <div class="row mb-3">
                        @if (Session::has('error'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
                        @endif
                        <form action="{{ route('keuangan.update', $pesanan->id) }}" method="post" enctype="multipart/form-data"
                            class="tambah-setor" novalidate>
                            @csrf
                            @method('put') <!-- Tambahkan ini untuk menentukan method PUT -->
                            <div class="mb-3">
                                {{-- <label for="gambar2" class="form-label">gambar2</label> --}}
                                <img src="" id="img-preview" class="img-preview img-fluid w-30" alt="">
                                <input type="file" onchange="previewImage()"
                                    class="form-control @error('gambar2') is-invalid @enderror" accept="setor-images/*"
                                    name="gambar2" id="gambar2" placeholder="" aria-describedby="fileHelpId">
                                <div id="fileHelpId" class="form-text text-danger">Format jpg, jpeg, png</div>
                                <div class="invalid-feedback">
                                    {{ $errors->has('gambar2') ? $errors->first('gambar2') : '' }}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 mb-3">SIMPAN</button>

                        </form>
                    </div>
                @endif

                <div class="row mb-3 mt-4">
                    <div class="col-md-4"><strong>ID Pesanan:</strong></div>
                    <div class="col-md-8">{{ $pesanan->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Rekening Penjual:</strong></div>
                    <div class="col-md-8">
                        @if ($pesanan->rekening)
                            {{ $pesanan->rekening->no_rek }}
                        @else
                            Rekening tidak ditemukan
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Cara Bayar:</strong></div>
                    <div class="col-md-8">{{ $pesanan->bayar->cara_bayar }}</div>
                </div>
                @if ($pesanan && $pesanan->bayar_id != 0 && $pesanan->bayar_id != 1 && $pesanan->statusverifikasi)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Status:</strong></div>
                    <div class="col-md-8">{{ $pesanan->statusverifikasi->statusverifikasi }}</div>
                </div>
                @else

                @endif


                <div class="row mb-3">
                    <div class="col-md-4"><strong>Expedisi:</strong></div>
                    <div class="col-md-8">{{ $pesanan->expedisi->expedisi ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Status Pengiriman:</strong></div>
                    <div class="col-md-8">{{ $pesanan->status->status ?? '' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Penjual:</strong></div>
                    <div class="col-md-8">{{ $pesanan->user->name ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>No tlp Penjual:</strong></div>
                    <div class="col-md-8">{{ $pesanan->user->no_tlp ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Pembeli:</strong></div>
                    <div class="col-md-8">{{ $pesanan->pembeli->name ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>No tlp Pembeli:</strong></div>
                    <div class="col-md-8">{{ $pesanan->pembeli->no_tlp ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Alamat Pembeli:</strong></div>
                    <div class="col-md-8">{{ $pesanan->alamat ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nama Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->produk->nama_produk ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Jumlah Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->jumlah_produk ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Harga:</strong></div>
                    <div class="col-md-8">{{ $pesanan->harga ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>ID Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->produk->id ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Kode Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->produk->kode ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Kategori:</strong></div>
                    <div class="col-md-8">{{ $pesanan->produk->kategori->kategori ?? '' }}</div>
                </div>



            </div>




        </div>
    </div>


    <script>
        // Fungsi preview gambar2
        function previewImage() {
            const imgPreview = document.querySelector('#img-preview');
            const gambar2Input = document.querySelector('#gambar2');

            const filegambar2 = new FileReader();
            filegambar2.readAsDataURL(gambar2Input.files[0]);

            filegambar2.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

        // Validasi form
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.tambah-setor')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection
