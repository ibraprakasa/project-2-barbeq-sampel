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
            <link rel="stylesheet" type="text/css"
                href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
            <link rel="stylesheet" type="text/css"
                href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

           
            <table id="pesanan" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Pembeli</th>
                        <th scope="col">Harga total</th>
                        <th scope="col">Cara Bayar</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($pesanans as $item)
                        <tr class="">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $item->produk ? $item->produk->nama_produk : 'Produk tidak tersedia' }}</td>
                            <td>{{ $item->pembeli ? $item->pembeli->name : 'Pembeli tidak tersedia' }}</td>
                            <td>{{ $item->harga ? $item->harga : 'harga tidak ada' }}</td>
                            <td>{{ $item->bayar ? $item->bayar->cara_bayar : 'bayar tidak tersedia' }}</td>
                            <td>{{ $item->status ? $item->status->status : '' }}</td>
                            <td>
                                <a href="{{ route('all.show', $item->id) }}" class="btn btn-danger btn-sm" style="width: 30px; height: 30px;"><i class="bi bi-eye-fill"></i></a>
                                <form action="/all/{{ $item->id }}" method="post" class="d-inline">
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
@endsection
