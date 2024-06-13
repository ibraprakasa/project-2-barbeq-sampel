@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="row">
        <div class="col-lg-12 ">
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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
        <link rel="stylesheet" type="text/css"
            href="https:////cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

        <table id="pembeli" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Pembeli</th>
                    <th scope="col">No Tlp</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelis as $item)
                    <tr class="">
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->no_tlp }}</td>
                        <td>
                            <img class="rounded"
                            src="{{ $item->gambar ? asset('pembeli-images/' . $item->gambar) : asset('images/bbb/default_profil.WEBP') }}"
                            width="100" height="100" alt="User Image" style="float: left; margin-right: 10px;">
                        </td>
                        @can('superadmin', 'admin')
                            <td>
                                <a href="{{ route('pembeli.show', $item->id) }}" class="btn btn-danger btn-sm"
                                    style="width: 30px; height: 30px;"><i class="bi bi-eye-fill"></i></a>
                                <form action="{{ route('pembeli.destroy', $item->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Apakah anda yakin ingin hapus pembeli ? {{ $item->name }}')"
                                        class="badge bg-danger border-0" style="width: 30px; height: 30px;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        @endcan
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
            let table = new DataTable('#pembeli');
        </script>
    </div>
@endsection
