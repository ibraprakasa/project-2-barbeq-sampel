@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="row">
    <div class="col-lg-7">
       <form action="/produk/{{ $produk->kode }}" method="post" class="tambah-post" enctype="multipart/form-data" novalidate>
            <!-- Change method post to put for update -->
            @method('put')
            @csrf
            <h1 class="h2">Edit Produk</h1>

            @can('superadmin')
            <div class="mb-3">
                <label for="" class="form-label">User</label>
                <select class="form-select form-select-md" name="user_id" id="user_id">
                    @foreach ($users as $user)
                        @if (!$user->isadmin && !$user->issuperadmin)
                            <option value="{{ $user->id }}" {{ $user->id == $produk->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @endcan

            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk"
                        id="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" placeholder="Nama Produk" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('nama_produk') ? $errors->first('nama_produk') : 'Silahkan edit nama produk' }}
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select form-select-md" name="kategori_id" id="kategori">
                    @foreach ($kategoris as $item)
                        <option value="{{ $item->id }}" {{ old('kategori_id', $produk->kategori_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->kategori }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('harga') is-invalid @enderror" name="harga"
                        id="harga" value="{{ old('harga', $produk->harga) }}" placeholder="Harga" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('harga') ? $errors->first('harga') : 'Silahkan edit harga' }}
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><span data-feather="type"></span></span>
                    <input type="text" class="form-control @error('stock') is-invalid @enderror" name="stock"
                        id="stock" value="{{ old('stock', $produk->stock) }}" placeholder="Stock" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('stock') ? $errors->first('stock') : 'Silahkan edit stock' }}
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <img src="{{ $produk->gambar}}" id="img-preview" class="img-preview img-fluid w-50 mb-2 d-block" alt="Preview">
                <input type="hidden" name="oldImage" id="oldImage" value="{{ $produk->gambar }}">
                <input type="file" onchange="previewImage()" class="form-control @error('gambar') is-invalid @enderror" accept="produk-images/*" name="gambar" id="gambar" placeholder="Gambar" aria-describedby="fileHelpId">
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
                        id="detail" value="{{ old('detail', $produk->detail) }}" placeholder="Detail" required>
                    <div class="invalid-feedback">
                        {{ $errors->has('detail') ? $errors->first('detail') : 'Silahkan edit detail' }}
                    </div>
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary w-50 mb-3 me-2">SIMPAN</button>
                <a href="{{ route('produk.index') }}" class="btn btn-sm btn-danger w-50 mb-3">BATAL</a>
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
