@extends('dashboard.layouts.mains')

@section('admin-magang')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Info!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Rekening</h5>
                        <a href="{{ route('setting.index') }}" class="btn btn-sm btn-danger"><span data-feather="arrow-right"></span></a>
                    </div>
                    <div class="card-body">

                        @if (auth()->user()->isadmin || auth()->user()->issuperadmin || $rekenings->count() == 0)
                        <a href="{{ route('rekening.create') }}" class="btn btn-danger mb-3">Tambah Rekening</a>
                    @else
                        <div class="alert alert-warning" role="alert">
                            Anda hanya diperbolehkan memiliki satu rekening.
                        </div>
                    @endif


                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>user id</th>
                                        <th>Nama user</th>
                                        <th>Nama Bank</th>
                                        <th>No. Rekening</th>
                                        <th>Nama Pemilik</th>
                                        <th width="150px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekenings as $rekening)
                                        <tr>
                                            <td>{{ $rekening->user->id }}</td>
                                            <td>{{ $rekening->user->name }}</td>
                                            <td>{{ $rekening->nama_bank }}</td>
                                            <td>{{ $rekening->no_rek }}</td>
                                            <td>{{ $rekening->nama_pemilik }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary me-2" href="{{ route('rekening.edit', $rekening->id) }}">Edit</a>
                                                <form action="{{ route('rekening.destroy', $rekening->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus rekening ini?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
