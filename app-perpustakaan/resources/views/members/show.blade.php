@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <h1>Detail Anggota</h1>
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>

    <table>
        <tr><th style="width: 180px;">Nama</th><td>{{ $member['nama'] }}</td></tr>
        <tr><th>NIM</th><td>{{ $member['nim'] }}</td></tr>
        <tr><th>Email</th><td>{{ $member['email'] }}</td></tr>
        <tr><th>Nomor Telepon</th><td>{{ $member['nomor_telepon'] }}</td></tr>
        <tr><th>Alamat</th><td>{{ $member['alamat'] }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst($member['status']) }}</td></tr>
    </table>

    <h2 style="margin-top: 30px;">Riwayat Peminjaman</h2>
    <table>
        <thead>
            <tr>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Petugas</th>
                <th>Buku</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($member['loans'] as $loan)
                <tr>
                    <td>{{ $loan['tanggal_pinjam'] }}</td>
                    <td>{{ $loan['tanggal_kembali'] }}</td>
                    <td>{{ $loan['user']['name'] }}</td>
                    <td>
                        @foreach ($loan['loanItems'] as $item)
                            {{ $item['book']['judul'] }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        <span class="badge badge-{{ $loan['status'] }}">
                            {{ ucfirst($loan['status']) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Anggota ini belum pernah meminjam buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
'@
