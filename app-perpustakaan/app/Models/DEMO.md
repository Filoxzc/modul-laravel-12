# Skenario Demo Aplikasi Perpustakaan Digital Kampus (UAS)

## Data Akun Demo
* **Admin**: `admin@pens.ac.id` | Password: `password`
* **Petugas**: `petugas1@pens.ac.id` | Password: `password`

---

## Urutan Skenario Demo

1. **Persiapan Server**
   - Menjalankan server web utama: `php artisan serve --port=8000`
   - Menjalankan server API internal: `php artisan serve --port=8011`

2. **Autentikasi (Login)**
   - Buka `http://127.0.0.1:8000/login`
   - Login menggunakan akun Admin (`admin@pens.ac.id`).
   - Tunjukkan redirect otomatis ke halaman Dashboard.

3. **Dashboard & Konsumsi API**
   - Tunjukkan 3 kartu statistik (Total Buku, Total Anggota, Peminjaman Aktif) yang datanya dikonsumsi dari endpoint `GET /api/stats`.

4. **Kelola Kategori (Otorisasi Admin)**
   - Buka menu **Kategori**.
   - Tambah kategori baru, edit, lalu tunjukkan daftar kategori.

5. **Kelola Buku**
   - Buka menu **Buku**, perhatikan daftar buku bergaya Indonesia dan pagination rapi.
   - Tambahkan satu buku baru dengan memilih kategori yang sesuai.

6. **Kelola Anggota**
   - Buka menu **Anggota**, perhatikan data mahasiswa PENS dummy (@pens.ac.id).
   - Tambah satu data anggota baru.

7. **Transaksi Peminjaman**
   - Buka menu **Peminjaman**, klik **Tambah Peminjaman**.
   - Tunjukkan bahwa kolom Petugas terisi otomatis dari akun yang sedang login.
   - Pilih anggota dan buku yang dipinjam, lalu simpan.

8. **Proses Pengembalian Buku**
   - Di daftar peminjaman, klik tombol **Kembalikan** pada salah satu transaksi pinjaman aktif.
   - Konfirmasi, dan tunjukkan badge status berubah menjadi **Dikembalikan**.

9. **Laporan Peminjaman (Konsumsi API)**
   - Buka menu **Laporan**.
   - Tunjukkan tabel laporan peminjaman yang mengambil data dari endpoint `GET /api/loans`.

10. **Demo REST API di Postman**
    - Buka Postman collection `app-perpustakaan`.
    - Uji endpoint `GET /api/books?judul=Laravel`.
    - Uji endpoint `GET /api/stats`.
    - Tunjukkan respon berformat JSON yang konsisten.