@extends('dashboard.layouts.mains')
@section('admin-magang')

<br>
    <div class="row">

        <div class="col-lg-12">
            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
            @endif

            <br>
            <form action="/banner" method="post" enctype="multipart/form-data" class="tambah-banner" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label"> Gambar</label>
                    <img src="" id="img-preview" class="img-preview img-fluid w-30" alt="">
                    <input type="file" onchange="previewImage()"
                        class="form-control @error('gambar') is-invalid @enderror" accept="banner-images/*" name="gambar"
                        id="gambar" placeholder="" aria-describedby="fileHelpId">
                    <div id="fileHelpId" class="form-text text-danger">Format jpg,jpeg,png</div>
                    <div class="invalid-feedback">
                        {{ $errors->has('gambar') ? $errors->first('gambar') : '' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Detail</label>
                    <textarea class="form-control  @error('detail') is-invalid @enderror " name="detail" id="" rows="3"
                        required>{{ old('detail') }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->has('detail') ? $errors->first('detail') : 'Silahkan isi ket!' }}

                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary w-50 mb-3 me-2">SIMPAN</button>
                    <a href="{{ route('banner.index') }}" class="btn btn-sm btn-danger w-50 mb-3">BATAL</a>
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
