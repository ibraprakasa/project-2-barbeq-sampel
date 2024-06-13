@extends('dashboard.layouts.mains')

@section('admin-magang')
    <div class="container">
        <div class="ms-auto position-relative">
            {{-- <a href="{{ route('password.edit') }}" style="font-size: 20px; color: black;">Change Password</a> --}}
            <li class="breadcrumb-item" style="color: black; display: inline-block; vertical-align: middle;"><a href="{{ route('password.edit') }}" style="color: black;">Change Password</a></li>
        </div>
        <div class="ms-auto position-relative">
            {{-- <a href="{{ route('rekening.index') }}" style="font-size: 20px; color: black;">Daftar Rekening</a> --}}
            <li class="breadcrumb-item" style="color: black; display: inline-block; vertical-align: middle;"><a href="{{ route('rekening.index') }}" style="color: black;">Daftar Rekening</a></li>
        </div>
    </div>
@endsection
