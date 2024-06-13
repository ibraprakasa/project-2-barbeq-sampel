@extends('dashboard.layouts.mains')

@section('admin-magang')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>

    <body>
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Info!</strong> {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
            <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
                <link rel="stylesheet" type="text/css"
                    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
                <link rel="stylesheet" type="text/css"
                    href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
                <link rel="stylesheet" type="text/css"
                    href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

                <table id="pengiriman" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Pembeli</th>
                            <th scope="col">Produk</th>
                            <th scope="col">harga</th>
                            @can('admin')
                            <th scope="col">alamat</th>
                            @endcan
                            <th scope="col">cara bayar</th>
                            <th scope="col">Resi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengirimans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->pembeli ? $item->pembeli->name : 'Pembeli tidak ada' }}</td>
                                <td>{{ $item->produk ? $item->produk->nama_produk : 'Produk tidak tersedia' }}</td>
                                <td>{{ $item->harga ? $item->harga : 'Harga tidak ada' }}</td>
                                <td>{{ $item->bayar ? $item->bayar->cara_bayar : 'Bayar tidak tersedia' }}</td>
                                <td>
                                    <div>
                                        @if ($item->gambar3)
                                            <img src="{{ $item->gambar3 }}" style="max-height: 100px" class="img-fluid mt-2 d-block" alt="">
                                        @else
                                            Belum ada resi pengiriman
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        @if (Session::has('error'))
                                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
                                        @endif
                                        <form action="{{ route('pengiriman.update', $item->id) }}" method="post" enctype="multipart/form-data" class="tambah-resi" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <img src="" id="img-preview" class="img-preview img-fluid w-30" alt="">
                                                <input type="file" onchange="previewImage()" class="form-control @error('gambar3') is-invalid @enderror" accept="image/*" name="gambar3" id="gambar3">
                                                <div class="form-text text-danger">Format jpg, jpeg, png</div>
                                                <div class="invalid-feedback">
                                                    {{ $errors->has('gambar3') ? $errors->first('gambar3') : '' }}
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-danger w-100 mb-3">Simpan</button>
                                        </form>
                                    </div>
                                </td>
                                @can('admin')
                                    <td>{{ $item->user ? $item->user->alamat : 'Alamat pengirim tidak ada' }}</td>
                                @endcan
                                <td>
                                    <form action="{{ route('pengiriman.updateStatus', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class="form-select form-select-md" name="status_id" id="status_id">
                                            @foreach ($statuss as $status)
                                                <option value="{{ $status->id }}" {{ $item->status_id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('pengiriman.show', $item->id) }}" class="btn btn-danger btn-sm" style="width: 30px; height: 30px;"><i class="bi bi-eye-fill"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
                <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
                <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>

                <script type="text/javascript">
                    let table = new DataTable('#pengiriman');

                    function previewImage() {
                        const image = document.querySelector('#gambar3');
                        const imgPreview = document.querySelector('.img-preview');

                        imgPreview.style.display = 'block';

                        const oFReader = new FileReader();
                        oFReader.readAsDataURL(image.files[0]);

                        oFReader.onload = function(oFREvent) {
                            imgPreview.src = oFREvent.target.result;
                        };
                    }
                </script>
            </div>
        </section>
    </body>
    </html>
@endsection
