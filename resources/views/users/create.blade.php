@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah User Baru</h1>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="mb-3">
            <label for="nama_akun">Nama Akun</label>
            <input type="text" class="form-control" id="nama_akun" name="nama_akun" required value="{{ old('nama_akun') }}">
        </div>

        <div class="mb-3">
            <label for="bidang">Bidang</label>
            <select class="form-control" id="bidang" name="bidang" required>
                @foreach ($dispositions as $bid)
                    <option value="{{ $bid }}" {{ old('bidang') == $bid ? 'selected' : '' }}>{{ $bid }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" required>
                @foreach ($roles as $id => $name)
                    <option value="{{ $id }}" {{ old('role') == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
