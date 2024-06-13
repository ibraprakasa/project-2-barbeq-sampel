@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('rekening.update', $rekening->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_bank">Nama Bank</label>
                    <input type="text" class="form-control" id="nama_bank" name="nama_bank" value="{{ $rekening->nama_bank }}">
                </div>
                <div class="form-group">
                    <label for="no_rek">No. Rekening</label>
                    <input type="text" class="form-control" id="no_rek" name="no_rek" value="{{ $rekening->no_rek }}">
                </div>
                <div class="form-group" style="margin-bottom: 20px;"> <!-- Tambahkan style margin-bottom di sini -->
                    <label for="nama_pemilik">Nama Pemilik</label>
                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" value="{{ $rekening->nama_pemilik }}">
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary w-50 mb-3 me-2">SIMPAN</button>
                    <a href="{{ route('rekening.index') }}" class="btn btn-sm btn-danger w-50 mb-3">BATAL</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
