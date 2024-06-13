@extends('dashboard.layouts.mains')
@section('admin-magang')

    <br>
    <div class="row">

        <div class="col-lg-12">
            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
            @endif

            <br>
            <form action="/produk" method="post" enctype="multipart/form-data" class="tambah-barang" novalidate>
                @csrf


                    @can('superadmin')
                        <div class="mb-3">
                            <label for="" class="form-label">User</label>
                            <select class="form-select form-select-md" name="user_id" id="user_id">
                                @foreach ($users as $user)
                                    @if (!$user->isadmin && !$user->issuperadmin)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @endcan


                <div class="mb-3">
                    <label for="" class="form-label">Kode Barang</label>
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
                    <label for="" class="form-label">nama Produk</label>
                    <div class="input-group">
                        <span class="input-group-text" name="nama_produk" id="basic-addon1"><span
                                data-feather="align-left"></span></span>
                        <input type="text" class="form-control  @error('nama_produk') is-invalid @enderror"
                            value="{{ old('nama_produk') }}" name="nama_produk" id="nama_produk" placeholder="nama_produk"
                            required>
                        <div class="invalid-feedback">
                            {{ $errors->has('nama_produk') ? $errors->first('nama_produk') : 'Silahkan isi nama produk!' }}

                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Kategori</label>
                    <select class="form-select form-select-md" name="kategori_id" id="">
                        @foreach ($kategoris ?? [] as $item)
                            <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- <div class="mb-3">
                    <label for="" class="form-label">Kategori</label>
                    <select class="form-select form-select-md" name="kategori_id" id="">
                        @foreach ($kategoris as $item)
                            <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->kategori }} </option>
                        @endforeach
                    </select>
                </div> --}}

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


                <div class="mb-3">
                    <label for="" class="form-label">Stok</label>
                    <div class="input-group">
                        <span class="input-group-text" name="stock" id="basic-addon1"><span
                                data-feather="layers"></span></span>
                        <input type="text" class="form-control  @error('stock') is-invalid @enderror"
                            value="{{ old('stock') }}" name="stock" id="stock" placeholder="stock" required>
                        <div class="invalid-feedback">
                            {{ $errors->has('stock') ? $errors->first('stock') : 'Silahkan isi stock!' }}

                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="" class="form-label"> Gambar</label>
                    <img src="" id="img-preview" class="img-preview img-fluid w-30" alt="">
                    <input type="file" onchange="previewImage()"
                        class="form-control @error('gambar') is-invalid @enderror" accept="produk-images/*" name="gambar"
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
                    <a href="{{ route('produk.index') }}" class="btn btn-sm btn-danger w-50 mb-3">BATAL</a>
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
