@extends('dashboard.layouts.mains')
@section('admin-magang')
<div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
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

    <div class="container mt-2">
        <div class="table-responsive-lg">
            <!-- Stylesheets -->
            <link rel="stylesheet" type="text/css"
                href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
            <link rel="stylesheet" type="text/css"
                href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

            <!-- Table -->
            <table id="pesanan" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        {{-- <th scope="col">id pesanan</th> --}}
                        @cannot('admin')
                        <th scope="col">Nama Produk</th>
                        @endcannot
                        <th scope="col">Pembeli</th>
                        {{-- <th scope="col">Alamat</th> --}}
                        <th scope="col">Harga total</th>
                        {{-- <th scope="col">jumlah produk</th> --}}
                        <th scope="col">Cara Bayar</th>
                        <th scope="col">Bukti Transfer</th>
                        @can('admin')
                        <th scope="col">Status Verifikasi</th>
                        @endcan
                        <th scope="col">Action</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($pesanans as $item)
                        <tr class="">
                            <td scope="row">{{ $loop->iteration }}</td>
                            @unless(auth()->user()->isadmin || auth()->user()->issuperadmin)
                            <td>{{ $item->produk ? $item->produk->nama_produk : 'Produk tidak tersedia' }}</td>
                            @endunless
                            <td>{{ $item->pembeli ? $item->pembeli->name : 'Pembeli tidak tersedia' }}</td>
                            <td>{{ $item->harga ?? 'harga tidak ada' }}</td>
                            <td>{{ $item->bayar ? $item->bayar->cara_bayar : 'bayar tidak tersedia' }}</td>

                            <td>
                                @if ($item->bayar_id == 1)
                                    <span>Tidak perlu bukti</span>
                                @elseif (!$item->gambar)
                                    <span>Pembeli belum bayar</span>
                                @else
                                    <img src="{{ asset($item->gambar) }}" alt="Bukti Pembayaran" style="max-height: 100px" class="img-fluid mt-2 d-block">
                                @endif
                            </td>

                            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                                <td>
                                    <form action="{{ route('pesanan.updateStatusverifikasi', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class="form-select form-select-md" name="statusverifikasi_id"
                                            id="statusverifikasi_id">
                                            @foreach ($statusverifikasis as $statusverifikasi)
                                                <option value="{{ $statusverifikasi->id }}"
                                                    {{ $item->statusverifikasi_id == $statusverifikasi->id ? 'selected' : '' }}>
                                                    {{ $statusverifikasi->statusverifikasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    </form>
                                </td>
                            @endif
                            <td>
                                <a href="{{ route('pesanan.show', $item->id) }}" class="btn btn-danger btn-sm" style="width: 30px; height: 30px;"><i class="bi bi-eye-fill"></i></a>
                                <form action="/pesanan/{{ $item->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Apakah anda yakin ingin batalkan pesanan ? {{ $item->pembeli->name }}')"
                                        class="badge bg-danger border-0" style="width: 30px; height: 30px;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Scripts -->
            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
            <script type="text/javascript">
                let table = new DataTable('#pesanan');
            </script>
        </div>
    </div>
</div>
@endsection
