@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="row">
        <div class="col-lg-6">
            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
            @endif
            <form action="/categori" method="post" enctype="multipart/form-data" class="tambah-barang" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Kode Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text" name="kode" id="basic-addon1"><span
                                data-feather="type"></span></span>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode"
                            id="kode" value="{{ old('kode') }}" placeholder="kode" required>
                        <div class="invalid-feedback">
                            {{ $errors->has('kode') ? $errors->first('kode') : 'Silahkan isi kode' }}

                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text" name="kategori" id="basic-addon1"><span
                                data-feather="align-left"></span></span>
                        <input type="text" class="form-control  @error('kategori') is-invalid @enderror"
                            value="{{ old('kategori') }}" name="kategori" id="kategori" placeholder="kategori"
                            required>
                        <div class="invalid-feedback">
                            {{ $errors->has('kategori') ? $errors->first('kategori') : 'Silahkan isi Kategori produk!' }}

                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger w-100 mb-3">SIMPAN</button>

            </form>
        </div>
    </div>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.tambah-post')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script>
        //fungsi preview gambar

    </script>
@endsection
