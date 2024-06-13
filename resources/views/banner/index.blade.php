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
</div>

<div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
    <a href="/banner/create" class="btn btn-danger">
        <span data-feather='plus-circle'></span> Tambah Banner
    </a>
</div>

<div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
    <div class="table-responsive-lg">
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
        <link rel="stylesheet" type="text/css"
            href="https:////cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

        <table id="banner" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Detail</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($item->gambar)
                                <img src="{{ $item->gambar }}" style="max-height: 150px; max-width: 100%;" class="img-fluid mt-2 d-block" alt="Banner Image">
                            @else
                                <img src="https://source.unsplash.com/1200x400?placeholder" style="max-height: 100px; max-width: 100%;" class="img-fluid mt-2 d-block" alt="Placeholder Image">
                            @endif
                        </td>
                        <td style="word-wrap: break-word; white-space: normal; max-width: 400px; overflow-wrap: break-word;">{{ $item->detail }}</td>
                        <td>
                            <a href="{{ route('banner.edit', $item->id) }}" class="btn btn-danger btn-sm">Edit</a>
                           <form action="/banner/{{ $item->id }}" method="post" class="d-inline">
                                <!-- Timpa method post menjadi delete -->
                                @method('delete')
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Apakah anda yakin ingin hapus banner? {{ $item->id }}')"
                                    class="badge bg-danger border-0">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#banner').DataTable({
            columnDefs: [
                { width: '10%', targets: 0 },
                { width: '30%', targets: 1 },
                { width: '60%', targets: 2 }
            ],
            autoWidth: false,
            responsive: true
        });
    });
</script>
@endsection
