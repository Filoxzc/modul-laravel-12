@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
    <h1>Tambah Peminjaman</h1>
    <p><a href="{{ route('loans.index') }}">&larr; Kembali ke daftar</a></p>

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf

        <label for="member_id">Anggota</label>
        <select name="member_id" id="member_id">
            <option value="">-- Pilih Anggota --</option>
            @foreach ($members as $member)
                <option value="{{ $member['id'] }}" @selected(old('member_id') == $member['id'])>
                    {{ $member['nama'] }} ({{ $member['nim'] }})
                </option>
            @endforeach
        </select>
        @error('member_id') <div class="error">{{ $message }}</div> @enderror

        <label for="user_id">Petugas</label>
        <select name="user_id" id="user_id">
            <option value="">-- Pilih Petugas --</option>
            @foreach ($users as $user)
                <option value="{{ $user['id'] }}" @selected(old('user_id') == $user['id'])>
                    {{ $user['name'] }}
                </option>
            @endforeach
        </select>
        @error('user_id') <div class="error">{{ $message }}</div> @enderror

        <label for="tanggal_pinjam">Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}">
        @error('tanggal_pinjam') <div class="error">{{ $message }}</div> @enderror

        <label for="tanggal_kembali">Tanggal Kembali</label>
        <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali') }}">
        @error('tanggal_kembali') <div class="error">{{ $message }}</div> @enderror

        <label>Buku yang Dipinjam</label>
        <div style="border: 1px solid #ccc; padding: 10px; border-radius: 4px; max-height: 150px; overflow-y: auto; margin-top: 4px;">
            @forelse ($books as $book)
                <div style="margin-bottom: 6px;">
                    <label style="font-weight: normal; margin: 0; display: inline-flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="book_ids[]" value="{{ $book['id'] }}"
                            @checked(in_array($book['id'], old('book_ids', [])))>
                        {{ $book['judul'] }} (Stok: {{ $book['stok'] }})
                    </label>
                </div>
            @empty
                <p>Belum ada buku tersedia.</p>
            @endforelse
        </div>
        @error('book_ids') <div class="error">{{ $message }}</div> @enderror

        <div style="margin-top: 20px;">
            <button type="submit" class="btn">Simpan Transaksi</button>
        </div>
    </form>
@endsection
