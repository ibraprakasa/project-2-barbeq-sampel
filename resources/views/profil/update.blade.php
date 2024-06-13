@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="row">
    <div class="col-lg-7">
        <form action="{{ route('profil.update', $user->id) }}" method="post" class="tambah-post" enctype="multipart/form-data" novalidate>
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" value="{{ old('name', $user->name) }}" placeholder="Nama" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('name') ? $errors->first('name') : 'Silahkan edit nama ' }}
                    </div>
                </div>
            </div>


            <div class="mb-3">
                <label for="no_tlp" class="form-label">No Telephon</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('no_tlp') is-invalid @enderror" name="no_tlp"
                        id="no_tlp" value="{{ old('no_tlp', $user->no_tlp) }}" placeholder="no_tlp" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('no_tlp') ? $errors->first('no_tlp') : 'Silahkan edit no_tlp' }}
                    </div>
                </div>
            </div>


            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                        id="alamat" value="{{ old('alamat', $user->alamat) }}" placeholder="alamat" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('alamat') ? $errors->first('alamat') : 'Silahkan edit alamat' }}
                    </div>
                </div>
            </div>


            {{-- <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <img src="{{ $user->gambar}}" id="img-preview" class="img-preview img-fluid w-50 mb-2 d-block" alt="Preview">
                <input type="hidden" name="gambar" id="gambar" value="{{ $user->gambar }}">
                <input type="file" onchange="previewImage()" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" name="gambar" id="gambar" placeholder="Gambar" aria-describedby="fileHelpId">
                <div id="fileHelpId" class="form-text text-danger">Format jpg, jpeg, png</div>
                <div class="invalid-feedback">
                    {{ $errors->has('gambar') ? $errors->first('gambar') : ''}}
                </div>
            </div> --}}

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                @if($user->gambar)
                <img src="{{ asset('user-images/'.$user->gambar)}}" id="img-preview" class="img-preview img-fluid w-50 mb-2 d-block" alt="Preview">
                @else
                <div class="text-muted">Gambar sebelumnya tidak tersedia</div>
                @endif
                <input type="file" onchange="previewImage()" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" name="gambar" id="gambar" placeholder="Gambar" aria-describedby="fileHelpId">
                <div id="fileHelpId" class="form-text text-danger">Format jpg, jpeg, png</div>
                <div class="invalid-feedback">
                    {{ $errors->has('gambar') ? $errors->first('gambar') : ''}}
                </div>
            </div>



            <div class="mb-3 d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary w-50 mb-3 me-2">SIMPAN</button>
                <a href="{{ route('profil.index') }}" class="btn btn-sm btn-danger w-50 mb-3">BATAL</a>
            </div>

        </form>
    </div>
</div>
<script>
    // Function to preview image
    function previewImage(){
        const image = document.getElementById('gambar');
        const imgPreview = document.getElementById('img-preview');

        imgPreview.style.display = 'block';
        const ofReader = new FileReader();
        ofReader.readAsDataURL(image.files[0]);
        ofReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection
