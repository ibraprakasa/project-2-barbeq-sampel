@extends('dashboard.layouts.mains')
@section('admin-magang')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-right" style="margin-top: 50px;">

</div>

      <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-1">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="no_tlp" class="form-label">No Telephone</label>
                    <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{ old('no_tlp') }}">
                    @error('no_tlp')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="alamat" class="form-label">alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="isadmin" class="form-label">Isadmin</label>
                    <input type="text" class="form-control" id="isadmin" name="isadmin" value="1" readonly>
                    @error('isadmin')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1">
                    <label for="" class="form-label"> Gambar</label>
                    <img src="" id="img-preview" class="img-preview img-fluid w-30" alt="">
                    <input type="file" onchange="previewImage()"
                        class="form-control @error('gambar') is-invalid @enderror" accept="images/*" name="gambar"
                        id="gambar" placeholder="" aria-describedby="fileHelpId">
                    <div id="fileHelpId" class="form-text text-danger">Format jpg,jpeg,png</div>
                    <div class="invalid-feedback">
                        {{ $errors->has('gambar') ? $errors->first('gambar') : '' }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
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
