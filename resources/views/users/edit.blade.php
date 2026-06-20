@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_akun">Nama Akun</label>
            <input type="text" class="form-control" id="nama_akun" name="nama_akun" required value="{{ old('nama_akun', $user->name) }}">
        </div>

        <div class="mb-3">
            <label for="bidang">Bidang</label>
            <select class="form-control" id="bidang" name="bidang" required>
                @foreach ($dispositions as $bid)
                    <option value="{{ $bid }}" {{ $user->bidang == $bid ? 'selected' : '' }}>{{ $bid }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" required>
                @foreach ($roles as $id => $name)
                    <option value="{{ $id }}" {{ $user->roles->first()?->id == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="password">Password (kosongkan jika tidak diubah)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
