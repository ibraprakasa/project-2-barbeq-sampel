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

    <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
        <div class="table-responsive-lg">
            <!-- Stylesheets -->
            <link rel="stylesheet" type="text/css"
                href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
            <link rel="stylesheet" type="text/css"
                href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                <div
                    style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; flex: 1;">
                    <div
                        style="background-color: #001aff; color: white; padding: 10px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div>
                        <p style="margin: 0; font-weight: bold;">Total Pendapatan All User</p>
                        <p style="margin: 0;">Rp. {{ number_format($totalall, 0, ',', '.') }}</p>
                    </div>
                </div>
                <br>
                <h6 style="color: red;">Setor bisa dilakukan jika resi dan bukti pembayaran ada!!</h6>
            @endif
            @unless (auth()->user()->isadmin || auth()->user()->issuperadmin)
                <div style="display: flex; gap: 20px; margin-bottom: 20px;">

                    <div
                        style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; flex: 1;">
                        <div
                            style="background-color: #001aff; color: white; padding: 10px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div>
                            <p style="margin: 0; font-weight: bold;">Total Pendapatan</p>
                            <p style="margin: 0;">Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div
                        style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; flex: 1;">
                        <div
                            style="background-color: #28A745; color: white; padding: 10px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div>
                            <p style="margin: 0; font-weight: bold;">Total Pendapatan COD</p>
                            <p style="margin: 0;">Rp. {{ number_format($totalcod, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div
                        style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; flex: 1;">
                        <div
                            style="background-color: #ff0b0b; color: white; padding: 10px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div>
                            <p style="margin: 0; font-weight: bold;">Total Pendapatan Transfer</p>
                            <p style="margin: 0;">Rp. {{ number_format($totaltransfer, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <br>
            @endunless

            <table id="pesanan" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                            <th scope="col">Penjual</th>
                        @endif

                        @unless(auth()->user()->isadmin || auth()->user()->issuperadmin)
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga total</th>
                            <th scope="col">Jumlah produk</th>
                            <th scope="col">Status</th>
                        @endunless
                        <th scope="col">Cara transaksi</th>
                        <th scope="col">
                            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                                Bukti setor
                            @else
                                Pemasukan
                            @endif
                        </th>
                        @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                            <th scope="col">Nama bank</th>
                            <th scope="col">Rek penjual</th>
                        @endif
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pesanans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                                <td>{{ $item->user ? $item->user->name : 'Penjual tidak tersedia' }}</td>
                            @endif
                            @unless (auth()->user()->isadmin || auth()->user()->issuperadmin)
                                <td>{{ $item->produk ? $item->produk->nama_produk : 'Produk tidak tersedia' }}</td>
                                <td>{{ $item->harga ?? 'Harga tidak ada' }}</td>
                                <td>{{ $item->jumlah_produk ?? 'Jumlah tidak ada' }}</td>
                                <td>{{ $item->statusverifikasi ? $item->statusverifikasi->statusverifikasi : 'Verifikasi tidak tersedia' }}
                                </td>
                            @endunless

                            <td>{{ $item->bayar ? $item->bayar->cara_bayar : 'Tidak tersedia' }}</td>
                            <td>
                                @if ($item->gambar2)
                                    <img src="{{ asset($item->gambar2) }}" alt="Bukti setor" style="max-height: 70px"
                                        class="img-fluid mt-2 d-block">
                                @else
                                    Tidak ada setor
                                @endif
                            </td>
                            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                                <td>{{ $item->rekening ? $item->rekening->nama_bank : 'Rekening tidak tersedia' }}</td>
                                <td>{{ $item->rekening ? $item->rekening->no_rek : 'Rekening tidak tersedia' }}</td>
                            @endif
                            <td style="display: flex; align-items: center;">
                                <a href="{{ route('keuangan.show', $item->id) }}" class="btn btn-danger btn-sm"
                                    style="width: 30px; height: 30px; margin-right: 3px;">
                                    <i class="bi bi-wallet"></i>
                                </a>
                                @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                                    <form action="{{ route('keuangan.destroy', $item->id) }}" method="post"
                                        class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Apakah anda yakin ingin batalkan pesanan ? {{ $item->pembeli->name }}')"
                                            class="badge bg-danger border-0"
                                            style="width: 30px; height: 30px; margin-left: 3px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
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
@endsection
