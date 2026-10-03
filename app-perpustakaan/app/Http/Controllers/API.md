# Dokumentasi REST API Perpustakaan Digital

Base URL: `http://127.0.0.1:8000/api`  
Header Wajib: `Accept: application/json`

---

## Ringkasan Endpoint

| Method | Endpoint | Status Code | Deskripsi |
| :--- | :--- | :--- | :--- |
| **GET** | `/books` | `200 OK` | Daftar buku terpaginasi (filter `?judul=` & `?category_id=`) |
| **GET** | `/books/{id}` | `200 OK` / `404 Not Found` | Detail buku berdasarkan ID |
| **POST** | `/books` | `201 Created` / `422 Unprocessable Content` | Menambahkan data buku baru |
| **PUT** | `/books/{id}` | `200 OK` / `422 Unprocessable Content` | Memperbarui data buku |
| **DELETE**| `/books/{id}` | `200 OK` / `404 Not Found` | Menghapus buku |
| **GET** | `/members` | `200 OK` | Daftar anggota terpaginasi |
| **GET** | `/members/{id}` | `200 OK` / `404 Not Found` | Detail anggota |
| **GET** | `/loans` | `200 OK` | Daftar riwayat transaksi peminjaman |
| **POST** | `/loans` | `201 Created` / `422 Unprocessable Content` | Membuat transaksi peminjaman baru |
| **PUT** | `/loans/{id}/kembalikan` | `200 OK` / `404 Not Found` | Mengubah status pinjaman menjadi dikembalikan |
| **GET** | `/stats` | `200 OK` | Ringkasan statistik perpustakaan |

---

## Rincian & Contoh Response

### 1. GET `/api/books`
* **Query Params (Opsional)**: `judul=Laravel`, `category_id=1`, `page=1`
* **Response Status**: `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "judul": "Mastering Laravel",
      "penulis": "Taylor Otwell",
      "penerbit": "Informatika",
      "tahun_terbit": 2024,
      "isbn": "978-602-001",
      "stok": 5,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Teknologi"
      },
      "created_at": "2026-09-30T11:42:29.000000Z",
      "updated_at": "2026-09-30T11:42:29.000000Z"
    }
  ],
  "links": {
    "first": "[http://127.0.0.1:8000/api/books?page=1](http://127.0.0.1:8000/api/books?page=1)",
    "last": "[http://127.0.0.1:8000/api/books?page=1](http://127.0.0.1:8000/api/books?page=1)",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}

{
  "data": {
    "id": 1,
    "judul": "Mastering Laravel",
    "penulis": "Taylor Otwell",
    "penerbit": "Informatika",
    "tahun_terbit": 2024,
    "isbn": "978-602-001",
    "stok": 5,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi"
    },
    "created_at": "2026-09-30T11:42:29.000000Z",
    "updated_at": "2026-09-30T11:42:29.000000Z"
  }
}

{
  "judul": "Clean Code",
  "penulis": "Robert C. Martin",
  "penerbit": "Prentice Hall",
  "tahun_terbit": 2008,
  "isbn": "978-0132350884",
  "stok": 4,
  "category_id": 1
}

{
  "data": {
    "id": 3,
    "judul": "Clean Code",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2008,
    "isbn": "978-0132350884",
    "stok": 4,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi"
    },
    "created_at": "2026-10-03T14:15:00.000000Z",
    "updated_at": "2026-10-03T14:15:00.000000Z"
  }
}

{
  "message": "Judul buku wajib diisi. (and 4 more errors)",
  "errors": {
    "judul": ["Judul buku wajib diisi."],
    "penulis": ["Nama penulis wajib diisi."],
    "penerbit": ["Nama penerbit wajib diisi."],
    "tahun_terbit": ["Tahun terbit wajib diisi."],
    "stok": ["Jumlah stok wajib diisi."]
  }
}

{
  "judul": "Clean Code Updated Edition",
  "penulis": "Robert C. Martin",
  "penerbit": "Prentice Hall",
  "tahun_terbit": 2008,
  "isbn": "978-0132350884",
  "stok": 10,
  "category_id": 1
}

{
  "data": {
    "id": 3,
    "judul": "Clean Code Updated Edition",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2008,
    "isbn": "978-0132350884",
    "stok": 10,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi"
    },
    "created_at": "2026-10-03T14:15:00.000000Z",
    "updated_at": "2026-10-03T14:20:00.000000Z"
  }
}

{
  "message": "Buku berhasil dihapus."
}

{
  "data": [
    {
      "id": 1,
      "nama": "Filo Mahabah",
      "nim": "3123500001",
      "email": "filo@pens.ac.id",
      "nomor_telepon": "081234567890",
      "alamat": "Surabaya",
      "status": "aktif",
      "created_at": "2026-09-30T10:00:00.000000Z",
      "updated_at": "2026-09-30T10:00:00.000000Z"
    }
  ],
  "links": {
    "first": "[http://127.0.0.1:8000/api/members?page=1](http://127.0.0.1:8000/api/members?page=1)",
    "last": "[http://127.0.0.1:8000/api/members?page=1](http://127.0.0.1:8000/api/members?page=1)",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}

{
  "data": {
    "id": 1,
    "nama": "Filo Mahabah",
    "nim": "3123500001",
    "email": "filo@pens.ac.id",
    "nomor_telepon": "081234567890",
    "alamat": "Surabaya",
    "status": "aktif",
    "created_at": "2026-09-30T10:00:00.000000Z",
    "updated_at": "2026-09-30T10:00:00.000000Z"
  }
}

{
  "data": [
    {
      "id": 1,
      "member": {
        "id": 1,
        "nama": "Filo Mahabah"
      },
      "petugas": {
        "id": 1,
        "name": "Admin Perpustakaan"
      },
      "tanggal_pinjam": "2026-09-30",
      "tanggal_kembali": "2026-10-10",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "books": [
        {
          "id": 1,
          "judul": "Mastering Laravel"
        }
      ]
    }
  ],
  "links": {
    "first": "[http://127.0.0.1:8000/api/loans?page=1](http://127.0.0.1:8000/api/loans?page=1)",
    "last": "[http://127.0.0.1:8000/api/loans?page=1](http://127.0.0.1:8000/api/loans?page=1)",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}

{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-10-03",
  "tanggal_kembali": "2026-10-17",
  "book_ids": [1, 2]
}

{
  "data": {
    "id": 2,
    "member": {
      "id": 1,
      "nama": "Filo Mahabah"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-10-03",
    "tanggal_kembali": "2026-10-17",
    "tanggal_dikembalikan": null,
    "status": "dipinjam",
    "books": [
      {
        "id": 1,
        "judul": "Mastering Laravel"
      },
      {
        "id": 2,
        "judul": "Basis Data MySQL"
      }
    ]
  }
}

{
  "data": {
    "id": 1,
    "member": {
      "id": 1,
      "nama": "Filo Mahabah"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-09-30",
    "tanggal_kembali": "2026-10-10",
    "tanggal_dikembalikan": "2026-10-03",
    "status": "dikembalikan",
    "books": [
      {
        "id": 1,
        "judul": "Mastering Laravel"
      }
    ]
  }
}

{
  "total_buku": 2,
  "total_anggota": 1,
  "peminjaman_aktif": 1
}