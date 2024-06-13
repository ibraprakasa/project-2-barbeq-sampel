@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Rekening</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('rekening.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nama_bank">Nama Bank</label>
                            <input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="no_rek">No. Rekening</label>
                            <input type="text" class="form-control" id="no_rek" name="no_rek" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_pemilik">Nama Pemilik</label>
                            <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary w-50 me-2">SIMPAN</button>
                            <a href="{{ route('rekening.index') }}" class="btn btn-danger w-50">BATAL</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
