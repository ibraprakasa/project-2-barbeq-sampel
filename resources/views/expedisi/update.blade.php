@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="row">
    <div class="col-lg-7">
       <form action="/expedisi/{{ $expedisi->id }}" method="post" class="tambah-post" enctype="multipart/form-data" novalidate>
            <!-- Change method post to put for update -->
            @method('put')
            @csrf

            <div class="mb-3">
                <label for="expedisi" class="form-label">Nama Expedisi</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('expedisi') is-invalid @enderror" name="expedisi"
                        id="expedisi" value="{{ old('expedisi', $expedisi->expedisi) }}" placeholder="expedisi" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('expedisi') ? $errors->first('expedisi') : 'Silahkan edit expedisi' }}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="expedisi" class="form-label">Harga</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('harga') is-invalid @enderror" name="harga"
                    id="harga" value="{{ old('harga', $expedisi->harga) }}" placeholder="masukan harga" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('harga') ? $errors->first('harga') : 'Silahkan edit harga' }}
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
