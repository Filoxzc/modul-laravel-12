# Modul Ajar Pemrograman Framework — Laravel 12

<div style="text-align: justify;">

Selamat datang di modul ajar Pemrograman Framework menggunakan Laravel 12.

## Persiapan Sebelum Memulai

### Pengetahuan Prasyarat
- Dasar PHP native (variable, function, array, OOP dasar)
- Dasar HTML & CSS
- Familiar perintah terminal dasar (`cd`, buka/pindah folder)

### Software yang Harus Terinstal

| Software | Kegunaan | Cek Instalasi |
|---|---|---|
| PHP >= 8.2 | Menjalankan Laravel | `php --version` |
| Composer | Mengelola dependency PHP/Laravel | `composer --version` |
| MySQL | Database aplikasi | — |
| Node.js & NPM | Build asset frontend (Vite) | `node --version` |
| Git | Version control, wajib dipakai sejak Pertemuan 1 | `git --version` |
| Code Editor (disarankan VS Code) | Menulis kode | — |
| Postman | Menguji REST API, dipakai mulai Pertemuan 9 | — |
| Akun GitHub | Menyimpan repository `app-perpustakaan` | — |

Kalau belum pernah pakai Git/GitHub sama sekali, baca **[Git & GitHub — Dasar yang Perlu Diketahui](./tambahan/git-github-dasar.md)** dulu sebelum mulai Pertemuan 1 — repository dan checkpoint commit sudah jadi bagian wajib sejak pertemuan pertama.

## Navigasi Pertemuan

| Pertemuan | Topik | Link |
|---|---|---|
| 1 | Framework, MVC & Setup Proyek | [Buka](./pertemuan-01.md) |
| 2 | Routing & Request Lifecycle | [Buka](./pertemuan-02.md) |
| 3 | Controller, Request & Validation | [Buka](./pertemuan-03.md) |
| 4 | Blade Templating & Layout System | [Buka](./pertemuan-04.md) |
| 5 | Migration, Eloquent Model & CRUD | [Buka](./pertemuan-05.md) |
| 6 | UTS | [Buka](./pertemuan-06.md) |
| 7 | Eloquent Relationships | [Buka](./pertemuan-07.md) |
| 8 | Authentication & Middleware | [Buka](./pertemuan-08.md) |
| 9 | REST API Dasar | [Buka](./pertemuan-09.md) |
| 10 | Blade + Konsumsi API & Project Clinic | [Buka](./pertemuan-10.md) |
| 11 | UAS | [Buka](./pertemuan-11.md) |

## Materi Tambahan

Materi pendalaman di luar urutan Pertemuan 1–11 — boleh dibaca kapan saja sesuai kebutuhan, tidak termasuk cakupan UTS/UAS.

| Topik | Kapan Dibaca | Link |
|---|---|---|
| Git & GitHub — Dasar yang Perlu Diketahui | Sebelum Pertemuan 1, kalau belum pernah pakai Git sama sekali | [Buka](./tambahan/git-github-dasar.md) |
| N+1 Query Problem (pendalaman) | Setelah Pertemuan 7, kalau penjelasan singkat di sana masih kurang jelas | [Buka](./tambahan/n-plus-1-query-problem.md) |
| Glosarium — Daftar Istilah | Kapan saja, referensi cepat istilah lintas pertemuan | [Buka](./tambahan/glosarium.md) |

## Studi Kasus yang Digunakan

Pembelajaran di modul ini **tidak berpindah-pindah topik contoh** — dari Pertemuan 1 sampai UAS, seluruh konsep (MVC, routing, validasi, migration, relasi, autentikasi, API) dipraktikkan lewat satu studi kasus yang sama: **Sistem Perpustakaan Digital Kampus**, aplikasi yang dikelola Admin/Petugas untuk mengelola buku, anggota, dan transaksi peminjaman.

Beberapa fitur akhir yang akan terbentuk bertahap sepanjang semester:
- CRUD Kategori Buku, Buku, dan Anggota Perpustakaan
- Transaksi Peminjaman & Pengembalian Buku
- Autentikasi Petugas dengan proteksi route (Middleware)
- REST API untuk data buku, anggota, dan peminjaman
- Dashboard statistik & halaman laporan

Project ini dibangun bertahap, bukan sekaligus — jadi wajar kalau di pertemuan awal sebagian fitur di atas belum ada. Sebelum mulai mengerjakan pertemuan manapun (terutama Pertemuan 1 dan Pertemuan 5), baca dulu **[Studi Kasus & Desain Database](./studi-kasus-database.md)** untuk gambaran lengkap aktor, desain tabel, dan relasi antar tabelnya.

## Cara Mengakses Modul Ini

Repository modul ini ada di GitHub: `civeryoshioka/modul-laravel-12`. Ada tiga cara untuk membuka dan membaca modul ini di komputermu, khususnya lewat VS Code. Pilih salah satu sesuai kebutuhan dan kenyamananmu.

### 1. Unduh ZIP

Buka repository di GitHub → tombol hijau **Code** → **Download ZIP**, lalu ekstrak dan buka foldernya di VS Code.

- **Kelebihan:** Paling sederhana, tidak perlu instal Git atau paham perintahnya sama sekali. Langsung dapat semua file modul.
- **Kekurangan:** Kalau ada update/perbaikan modul di kemudian hari, kamu harus unduh ulang manual dan tidak ada riwayat perubahan (history). Tidak cocok kalau modul ini juga jadi tempat kamu menyimpan progres tugas lewat Git, karena folder hasil ekstrak ZIP bukan repository Git.

### 2. Clone via Git

Buka terminal, jalankan:

```bash
git clone https://github.com/civeryoshioka/modul-laravel-12.git
```

lalu buka folder hasil clone-nya di VS Code (`code modul-laravel-12`).

- **Kelebihan:** Bisa update modul kapan saja cukup dengan `git pull` tanpa unduh ulang. Sekalian jadi latihan Git sejak awal (relevan karena Git wajib dipakai sejak Pertemuan 1). Riwayat perubahan modul bisa dilihat lewat `git log`.
- **Kekurangan:** Wajib sudah instal Git dan familiar perintah dasarnya. Kalau salah perintah (misalnya push tanpa sadar ke repo modul), berpotensi bikin bingung — sebaiknya clone modul ini terpisah dari repository tugas pribadi (`app-perpustakaan`).

### 3. Baca Langsung di GitHub

Buka file `.md` langsung di halaman GitHub lewat browser, tanpa mengunduh apa pun.

- **Kelebihan:** Paling cepat untuk sekadar membaca atau mengecek sesuatu, tidak butuh setup apa pun, bisa dari HP sekalipun.
- **Kekurangan:** Tidak praktis untuk belajar sambil praktik coding, karena kamu harus bolak-balik antara browser dan VS Code. Tidak ada modul tersimpan secara lokal untuk dibaca offline.

**Rekomendasi:** kalau kamu sudah wajib pakai Git sejak Pertemuan 1, sekalian saja **clone** modul ini — jadi latihan Git tambahan dan memudahkan update di pertemuan-pertemuan berikutnya. Kalau belum siap dengan Git sama sekali, **unduh ZIP** dulu tidak masalah, sambil pelan-pelan belajar Git dari materi [Git & GitHub — Dasar yang Perlu Diketahui](./tambahan/git-github-dasar.md).

</div>