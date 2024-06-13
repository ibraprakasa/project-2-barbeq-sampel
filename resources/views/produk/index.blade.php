@extends('dashboard.layouts.mains')
@section('admin-magang')
<div class="row">

        <div class="col-lg-15">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Info!</strong> {{ session('success') }}
                </div>
            @endif
        </div>

        @cannot('admin')
        <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
                <a href="/produk/create" class="btn btn-danger"><span data-feather='plus-circle'></span>
                    Tambah Produk</a>
               
            </div>
        @endcannot

    </div>

    <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
        <div class="table-responsive-lg">
            <link rel="stylesheet" type="text/css"
                href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
            <link rel="stylesheet" type="text/css"
                href="https:////cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

            <table id="produk" class="table table-striped" style="width:100%">

                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode produk</th>
                        <th scope="col">Nama Produk</th>
                        {{-- <th scope="col">Kategori Produk</th> --}}
                        <th scope="col">Stock</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Gambar</th>
                        @can('admin')
                            <th scope="col">penjual</th>
                        @endcan

                            <th scope="col">Action</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($produks as $item)
                        <tr class="">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            {{-- <td>{{ $item->kategori->kategori }}</td> --}}
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>
                                @if ($item->gambar)
                                    <img src="{{ $item->gambar }}" style="max-height: 100px" class="img-fluid mt-2 d-block"
                                        alt="{{ $item->nama_produk }}">
                                @else
                                    <img src="https://source.unsplash.com/1200x400? {{ $item->nama_produk }}"
                                        class="img-fluid mt-2" alt="{{ $item->nama_produk }}">
                                @endif
                            </td>

                            @can('admin')
                                <td>{{ $item->user->name }}</td>
                            @endcan

                                <td>
                                    <a href="{{ route('produk.show', $item->kode) }}" class="btn btn-danger btn-sm" style="width: 30px; height: 30px;"><i class="bi bi-eye-fill"></i></a>
                                    @cannot('admin')
                                    <a href="{{ route('produk.edit', $item->kode) }}" class="btn btn-danger btn-sm" style="width: 30px; height: 30px;"><i class="bi bi-pencil-square"></i></a>
                                   <form action="/produk/{{ $item->kode }}" method="post" class="d-inline">
                                        <!-- Timpa method post menjadi delete -->
                                        @method('delete')
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Apakah anda yakin ingin hapus ? {{ $item->nama_produk }}')"
                                            class="badge bg-danger border-0" style="width: 30px; height: 30px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @endcannot
                                </td>

                        </tr>
                    @endforeach

                    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>

                    <script type="text/javascript">
                        let table = new DataTable('#produk');
                    </script>

                </tbody>
            </table>
        </div>

    </div>
@endsection
