@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <h1>Profil Pengguna</h1>

    <table>
        <tr><th style="width: 180px;">Nama</th><td>{{ $user->name }}</td></tr>
        <tr><th>Email</th><td>{{ $user->email }}</td></tr>
        <tr><th>Role</th><td><span class="badge badge-dipinjam">{{ ucfirst($user->role) }}</span></td></tr>
    </table>

    <h2 style="margin-top: 30px;">Ganti Password</h2>
    <form action="{{ route('profile.password') }}" method="POST" style="max-width: 450px;">
        @csrf
        @method('PUT')

        <label for="current_password">Password Lama</label>
        <input type="password" name="current_password" id="current_password" style="width: 100%; padding: 6px; margin-top: 4px;">
        @error('current_password') <div class="error" style="color: #b91c1c; font-size: 13px;">{{ $message }}</div> @enderror

        <label for="password" style="margin-top: 12px; display: block;">Password Baru</label>
        <input type="password" name="password" id="password" style="width: 100%; padding: 6px; margin-top: 4px;">
        @error('password') <div class="error" style="color: #b91c1c; font-size: 13px;">{{ $message }}</div> @enderror

        <label for="password_confirmation" style="margin-top: 12px; display: block;">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" id="password_confirmation" style="width: 100%; padding: 6px; margin-top: 4px;">

        <div style="margin-top: 20px;">
            <button type="submit" class="btn">Update Password</button>
        </div>
    </form>
@endsection
