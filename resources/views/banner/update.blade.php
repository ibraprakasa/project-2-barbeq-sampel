@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="row">
    <div class="col-lg-7">
       <form action="/banner/{{ $banner->id }}" method="post" class="tambah-post" enctype="multipart/form-data" novalidate>
            <!-- Change method post to put for update -->
            @method('put')
            @csrf

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <img src="{{ $banner->gambar}}" id="img-preview" class="img-preview img-fluid w-50 mb-2 d-block" alt="Preview">
                <input type="hidden" name="oldImage" id="oldImage" value="{{ $banner->gambar }}">
                <input type="file" onchange="previewImage()" class="form-control @error('gambar') is-invalid @enderror" accept="banner-images/*" name="gambar" id="gambar" placeholder="Gambar" aria-describedby="fileHelpId">
                <div id="fileHelpId" class="form-text text-danger">Format jpg, jpeg, png</div>
                <div class="invalid-feedback">
                    {{ $errors->has('gambar') ? $errors->first('gambar') : ''}}
                </div>
            </div>

            <div class="mb-3">
                <label for="detail" class="form-label">Detail</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('detail') is-invalid @enderror" name="detail"
                        id="detail" value="{{ old('detail', $banner->detail) }}" placeholder="Detail" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('detail') ? $errors->first('detail') : 'Silahkan edit detail' }}
                    </div>
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
