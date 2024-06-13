@extends('dashboard.layouts.mains')

@section('admin-magang')
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
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

            <!-- Table -->
            <table id="all" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Penjual</th>
                        <th scope="col">Pembeli</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Cara Bayar</th>
                        <th scope="col">Bukti Transfer</th>
                        <th scope="col">Status Verifikasi</th>
                        <th scope="col">Status pengiriman</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanans as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->produk ? $item->produk->nama_produk : 'Produk tidak tersedia' }}</td>
                            <td>{{ $item->user ? $item->user->name : 'Pembeli tidak tersedia' }}</td>
                            <td>{{ $item->pembeli ? $item->pembeli->name : 'Pembeli tidak tersedia' }}</td>
                            <td>{{ $item->pembeli ? $item->alamat : 'Alamat tidak tersedia' }}</td>
                            <td>{{ $item->produk ? $item->produk->harga : 'Harga tidak tersedia' }}</td>
                            <td>{{ $item->bayar ? $item->bayar->cara_bayar : 'Bayar tidak tersedia' }}</td>
                            <td>
                                @if ($item->bayar_id == 1)
                                    <span>Tidak perlu bukti</span>
                                @elseif ($item->bayar_id == 2 && (!$item->bayar || !$item->bayar->gambar))
                                    <span>Bukti telah diproses</span>
                                @else
                                    @if ($item->bayar && $item->bayar->gambar)
                                        <img src="{{ url('/bayar-images/' . $item->bayar->gambar) }}" alt="Bukti Pembayaran" style="max-height: 100px" class="img-fluid mt-2 d-block">
                                    @else
                                        <span>Bukti sedang diproses</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('all.updateStatusverifikasi', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select class="form-select form-select-md" name="statusverifikasi_id" id="statusverifikasi_id">
                                        @foreach ($statusverifikasis as $statusverifikasi)
                                            <option value="{{ $statusverifikasi->id }}" {{ $item->statusverifikasi_id == $statusverifikasi->id ? 'selected' : '' }}>
                                                {{ $statusverifikasi->statusverifikasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('all.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select class="form-select form-select-md" name="status_id" id="status_id">
                                        @foreach ($statuss as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $item->status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('all.destroy', $item->id) }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" onclick="return confirm('Apakah anda yakin ingin batalkan pesanan ? {{ $item->pembeli->name }}')" class="badge bg-danger border-0">
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
                let table = new DataTable('#all');
            </script>
        </div>
    </div>
@endsection
