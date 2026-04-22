# 🚀 Sistem Manajemen Blog (CMS) & Frontend Publik

Sistem Manajemen Blog interaktif berbasis **PHP MySQL Native** dengan desain UI/UX berstandar industri (Glassmorphism & Micro-animations). Proyek ini dibagi menjadi dua bagian utama:
1. **CMS (Content Management System) / Backend**: Panel admin untuk kelola Kategori, Artikel, dan Penulis.
2. **Frontend Publik**: Antarmuka bagi pembaca blog yang terintegrasi secara dinamis dengan CMS.

---

## 🛠️ Tech Stack
- **Frontend Publik**: HTML5, Vanilla CSS3 (Custom Variables, Modern Layout), Vanilla JS
- **CMS Backend**: PHP (Native Procedural/OOP mixed), MySQLi (Prepared Statements)
- **Database**: MySQL / MariaDB
- **Icons**: Font Awesome 6.5.1
- **Fonts**: Google Fonts (Inter & Space Grotesk)

---

## ⚙️ Fitur Utama
- **CRUD Super Cepat (No-Reload):** Papan kendali (CMS) murni menggunakan AJAX Fetch API untuk menambah, mengedit, dan menghapus artikel tanpa *refresh* halaman.
- **Upload Gambar:** Fitur unggah gambar profil penulis dan gambar sampul artikel (tersimpan rapi di direktori `uploads_penulis/` dan `uploads_artikel/`).
- **Database Relasional:** Keterikatan data antara Penulis, Kategori, dan Artikel (*Foreign Keys*).
- **Desain Premium:** Pengalaman membaca dengan palet warna "Dark Neo", *hover animations*, serta *glassmorphism navbar*.

---

## 💻 Panduan Instalasi di Komputer Lain (Menggunakan XAMPP)

Untuk menjalankan *source code* ini pada komputer/laptop lain menggunakan XAMPP, silakan ikuti petunjuk langkah demi langkah di bawah ini dengan berurutan.

### 1. Persiapan Direktori (Clone / Copy)
1. Aktifkan aplikasi **XAMPP** (Start module **Apache** dan **MySQL**).
2. Masuk ke dalam direktori instalasi XAMPP kamu, tepatnya di folder `htdocs` (biasanya di `C:\xampp\htdocs\`).
3. Taruh folder projek ini ke dalam `htdocs`. Pastikan susunannya agar tidak terlalu panjang.
   Sebagai contoh, ubah nama foldernya menjadi `blog_cms` sehingga letaknya berada di: 
   `C:\xampp\htdocs\blog_cms`

### 2. Konfigurasi Database (Penting!)
Proyek ini membutuhkan database agar dapat berjalan. Sistem tidak akan bisa memuat data jika *database* belum dibuat.
1. Buka browser, lalu akses http://localhost/phpmyadmin/
2. Di panel sebelah kiri, klik tulisan **New** (Baru) untuk membuat database.
3. Masukkan nama database: `db_blog`, lalu klik tombol **Create** (Buat).
4. Klik *database* `db_blog` yang baru saja kamu buat.
5. Klik tab **Import** (Impor) di deretan menu atas.
6. Klik tombol **Choose File** (Pilih File), lalu cari dan pilih file bernama **`db_blog.sql`** yang ada di dalam *folder* projek ini.
7. *Scroll* ke paling bawah dan klik tombol **Go** (Kirim) untuk mengeksekusi import tabel.

### 3. Penyesuaian File Koneksi (Opsional)
Buka file `koneksi.php` pada *text editor*. Secara default konfigurasinya adalah:
```php
$host = 'localhost';
$db   = 'db_blog';
$user = 'root';
$pass = ''; // <--- Ubah ini jika MySQL kamu memakai password
```
> **Catatan:** Jika *MySQL/phpMyAdmin* di laptop tujuan memiliki password untuk akun *root*, kamu wajib mengisi password tersebut di dalam tanda kutip string `$pass`. Jika tidak ada password (umumnya bawaan XAMPP kosong), biarkan saja tetap kosong.

### 4. Mengakses Aplikasi di Browser
Susunan URL menyesuaikan dengan lokasi *folder* projekmu di `htdocs`. Misalnya kamu menggunakan struktur folder `htdocs/blog_cms/`, maka:

🌎 **1. Akses Tampilan Web Pembaca (Frontend):**
Untuk melihat tata letak hasil tulisan blog, ketik pada browser:
👉 `http://localhost/blog_cms/public/`

🔐 **2. Akses Tampilan Dashboard Admin (CMS):**
Untuk menambahkan, mengedit, atau menghapus artikel serta memanajemen penulis, ketik pada browser:
👉 `http://localhost/blog_cms/index.php`

---

## 📁 Struktur Direktori
```text
/
├── public/                 # Folder Website Publik (Pembaca)
│   ├── assets/             #   Assets Frontend (CSS / JS)
│   ├── index.php           #   Halaman Beranda Blog
│   ├── article.php         #   Halaman Detail Artikel
│   └── auth.php            #   UI Mockup Login / Register
├── uploads_artikel/        # Media penyimpanan cover artikel (Auto)
├── uploads_penulis/        # Media penyimpanan profil penulis (Auto)
├── ambil_*.php             # Modul AJAX READ: Mengambil list data JSON
├── simpan_*.php            # Modul AJAX CREATE: Insert ke database
├── update_*.php            # Modul AJAX UPDATE: Update ke database MySQL
├── hapus_*.php             # Modul AJAX DELETE: Hapus data database + hapus file upload
├── db_blog.sql             # SQL Dump skema struktur database (Kategori, Artikel, Penulis)
├── koneksi.php             # Jembatan koneksi ke MySQL menggunakan PDO/MySQLi
└── index.php               # Halaman Papan Kendali Utama (CMS Dashboard)
```

Happy Coding! ✨