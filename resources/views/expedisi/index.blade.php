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

    <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
        <a href="/expedisi/create" class="btn btn-danger">
            <span data-feather='plus-circle'></span> Tambah Expedisi
        </a>
    </div>
</div>

<div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
    <div class="table-responsive-lg">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
        <link rel="stylesheet" type="text/css" href="https:////cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

        <table id="expedisi" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Expedisi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expedisis as $item)
                    <tr class="">
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td>{{ $item->expedisi }}</td>
                        <td>{{ $item->harga }}</td>
                        <td>
                            <a href="{{ route('expedisi.edit', $item->id) }}" class="btn btn-danger btn-sm">Edit</a>
                            <form action="/expedisi/{{ $item->id }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" onclick="return confirm('Apakah anda yakin ingin hapus ? {{ $item->expedisi }}')" class="badge bg-danger border-0" style="width: 30px; height: 30px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
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
            let table = new DataTable('#expedisi');
        </script>
    </div>
</div>
@endsection
