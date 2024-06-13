@extends('dashboard.layouts.mains')

@section('admin-magang')
    <div class="container">

        <div class="row">
            <div class="col-md-4">
                {{-- <h4>Profil</h4>
                <br> --}}
                <div class="card mb-3">

                    <div class="card-body">
                        <h5 class="card-title">{{ $user->username }}</h5>
                        <div class="image-frame" style="padding-bottom: 15px;">
                            <img src="{{ url('user-images/'.$user->gambar) }}" width="150" height="150" alt="User Image" style="vertical-align: middle;">
                        </div>
                        <p class="card-text" style="margin-bottom: 5px;"><strong>Username:</strong> {{ $user->name ?? 'Silahkan lengkapi profil' }}</p>
                        <p class="card-text" style="margin-bottom: 5px;"><strong>No.Telepon:</strong> {{ $user->no_tlp ?? 'Silahkan lengkapi profil' }}</p>
                        <p class="card-text" style="margin-bottom: 5px;"><strong>Alamat:</strong> {{ $user->alamat ?? 'Silahkan lengkapi profil' }}</p>

                        <form action="{{ route('profil.edit', $user->id) }}" method="GET"> <!-- Ganti route ke profil.edit -->
                            @csrf
                            <button type="submit" class="btn btn-primary">Edit Profil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
