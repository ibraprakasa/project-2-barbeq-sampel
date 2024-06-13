@extends('dashboard.layouts.mains')
@section('admin-magang')

<br>
    <div class="row">

        <div class="col-lg-12">
            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
            @endif

            <br>
            <form action="/expedisi" method="post" enctype="multipart/form-data" class="tambah-barang" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="" class="form-label">Nama Expedisi</label>
                    <div class="input-group">
                        <span class="input-group-text" name="expedisi" id="basic-addon1"><span
                                data-feather="align-left"></span></span>
                        <input type="text" class="form-control  @error('expedisi') is-invalid @enderror"
                            value="{{ old('expedisi') }}" name="expedisi" id="expedisi" placeholder="expedisi"
                            required>
                        <div class="invalid-feedback">
                            {{ $errors->has('expedisi') ? $errors->first('expedisi') : 'Silahkan isi nama expedisi!' }}

                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="" class="form-label">Harga </label>
                    <div class="input-group">
                        <span class="input-group-text" name="harga" id="basic-addon1"><span
                                data-feather="dollar-sign"></span></span>
                        <input type="text" class="form-control  @error('harga') is-invalid @enderror"
                            value="{{ old('harga') }}" name="harga" id="harga" placeholder="harga" required>
                        <div class="invalid-feedback">
                            {{ $errors->has('harga') ? $errors->first('harga') : 'Silahkan isi harga!' }}

                        </div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary w-50 mb-3 me-2">SIMPAN</button>
                    <a href="{{ route('expedisi.index') }}" class="btn btn-sm btn-danger w-50 mb-3">BATAL</a>
                </div>

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
        function previewImage() {
            const image = document.getElementById('gambar');
            const imgPreview = document.getElementById('img-preview');

            imgPreview.style.display = 'block';
            const ofReader = new FileReader();
            ofReader.readAsDataURL(image.files[0]);
            ofReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
