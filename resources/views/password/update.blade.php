<!-- password\update.blade.php -->

@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="row mt-4"> <!-- Tambahkan margin di sini -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <br>
                {{-- <h5 class="card-title">Change Password</h5> --}}
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="curr_password" class="form-label">Password Sebelumnya</label>
                        <input type="password" id="curr_password" name="curr_password" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <button id="updateTeacherProfile" type="submit" class="btn btn-primary w-50 mb-3 me-2">Update</button>
                        <a href="{{ route('setting.index') }}" class="btn btn-sm btn-danger w-50 mb-3">BATAL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
