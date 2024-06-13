@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="row">
        <div class="col-lg-6">
            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
            @endif
            <form action="/profil" method="post" enctype="multipart/form-data" class="tambah-barang" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Kode Penjual</label>
                    <div class="input-group">
                        <span class="input-group-text" name="kode" id="basic-addon1"><span
                                data-feather="type"></span></span>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode"
                            id="kode" value="{{ old('kode') }}" placeholder="penj-nama user" required>
                        <div class="invalid-feedback">
                            {{ $errors->has('kode') ? $errors->first('kode') : 'Silahkan isi kode' }}

                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">nama Penjual</label>
                    <div class="input-group">
                        <span class="input-group-text" name="nama_penjual" id="basic-addon1"><span
                                data-feather="align-left"></span></span>
                        <input type="text" class="form-control  @error('nama_penjual') is-invalid @enderror"
                            value="{{ old('nama_penjual') }}" name="nama_penjual" id="nama_penjual" placeholder="nama penjual"
                            required>
                        <div class="invalid-feedback">
                            {{ $errors->has('nama_penjual') ? $errors->first('nama_penjual') : 'Silahkan isi nama penjual!' }}

                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="" class="form-label">no tlp </label>
                    <div class="input-group">
                        <span class="input-group-text" name="no_tlp" id="basic-addon1"><span
                                data-feather="dollar-sign"></span></span>
                        <input type="text" class="form-control  @error('no_tlp') is-invalid @enderror"
                            value="{{ old('no_tlp') }}" name="no_tlp" id="no_tlp" placeholder="no_tlp" required>
                        <div class="invalid-feedback">
                            {{ $errors->has('no_tlp') ? $errors->first('no_tlp') : 'Silahkan isi no tlp!' }}

                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Alamat Penjual</label>
                    <textarea class="form-control  @error('alamat_penjual') is-invalid @enderror " name="alamat_penjual" id="" rows="3"
                        required>{{ old('alamat_penjual') }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->has('alamat_penjual') ? $errors->first('alamat_penjual') : 'Silahkan isi Alamat!' }}

                    </div>
                </div>


                <div class="mb-3">
                    <label for="" class="form-label"> Gambar</label>
                    <img src="" id="img-preview" class="img-preview img-fluid w-30" alt="">
                    <input type="file" onchange="previewImage()"
                        class="form-control @error('gambar') is-invalid @enderror" accept="user-images/*" name="gambar"
                        id="gambar" placeholder="" aria-describedby="fileHelpId">
                    <div id="fileHelpId" class="form-text text-danger">Format jpg,jpeg,png</div>
                    <div class="invalid-feedback">
                        {{ $errors->has('gambar') ? $errors->first('gambar') : '' }}
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
