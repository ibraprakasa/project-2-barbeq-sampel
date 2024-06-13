@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="row">
    <div class="col-lg-7">
       <form action="/categori/{{ $kategori->id }}" method="post" class="tambah-post" enctype="multipart/form-data" novalidate>
            <!-- Change method post to put for update -->
            @method('put')
            @csrf

            <div class="mb-3">
                <label for="kode" class="form-label">Kode Kategori</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode"
                        id="kode" value="{{ old('kode', $kategori->kode) }}" placeholder="kode" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('kode') ? $errors->first('kode') : 'Silahkan edit kode' }}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Nama Kategori</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('kategori') is-invalid @enderror" name="kategori"
                    id="kategori" value="{{ old('kategori', $kategori->kategori) }}" placeholder="masukan kategori" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('kategori') ? $errors->first('kategori') : 'Silahkan edit kategori' }}
                    </div>
                </div>
            </div>

            {{-- <button type="submit" class="btn btn-danger w-100 mb-3">SIMPAN</button> --}}
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary w-50 mb-3 me-2">SIMPAN</button>
                <a href="{{ route('categori.index') }}" class="btn btn-sm btn-danger w-50 mb-3">BATAL</a>
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
