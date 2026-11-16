PPDB SEKOLAH - WEBSITE PENDAFTARAN SISWA BARU
================================================

TEKNOLOGI
- PHP 8+
- MySQL / MariaDB
- HTML, CSS, JavaScript
- Dirancang untuk XAMPP

CARA MENJALANKAN
1. Ekstrak folder ppdb-siswa-modern ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL melalui XAMPP Control Panel.
3. Buka browser: http://localhost/ppdb-siswa-modern/
4. Database db_ppdb_sekolah akan dibuat otomatis saat halaman dibuka.
   Jika ingin membuat manual, import database/schema.sql melalui phpMyAdmin.

AKUN ADMIN DEMO
URL      : http://localhost/ppdb-siswa-modern/login.php
Username : adminppdb
Password : AdminPPDB#2026

AKUN CALON SISWA DEMO
URL      : http://localhost/ppdb-siswa-modern/login.php
Email    : calon@demo.test
Password : CalonSiswa#2026
Nama     : Calon Siswa Demo
No. WA   : 081234567890

Kedua akun demo dibuat otomatis saat website pertama kali dibuka.
Password akun admin dan calon siswa disimpan menggunakan password_hash.
Akun calon siswa demo dapat digunakan untuk mencoba dashboard siswa.
Untuk uji formulir PPDB, akun demo dapat mengisi formulir dari dashboard.
Ganti atau hapus akun demo sebelum website digunakan secara publik.

ALUR AKUN SISWA
1. Buka halaman Daftar Akun: http://localhost/ppdb-siswa-modern/register.php
2. Buat akun menggunakan nama lengkap, email aktif, nomor WhatsApp, dan password.
3. Login melalui http://localhost/ppdb-siswa-modern/login.php menggunakan email dan password.
4. Siswa masuk ke dashboard pribadi, lalu mengisi formulir PPDB.
5. Siswa dapat login kembali untuk memantau status pendaftaran.
6. Satu akun siswa hanya dapat mengirim satu formulir pendaftaran.

FITUR
- Website publik dan halaman informasi PPDB
- Registrasi akun siswa dan login sebelum mengisi formulir PPDB
- Nomor pendaftaran otomatis
- Dashboard siswa untuk memantau status pendaftaran secara pribadi
- Login dan logout admin
- Dashboard ringkasan jumlah pendaftar
- Pencarian dan filter status
- Detail biodata calon siswa dan orang tua
- Admin dapat mengubah status dan memberi catatan
- Responsive untuk desktop, tablet, dan smartphone
- Query database menggunakan prepared statements
- Password admin disimpan menggunakan password_hash

CATATAN PENTING
- Website ini merupakan template awal yang dapat disesuaikan dengan identitas sekolah.
- Nama sekolah, logo, alamat, kontak, periode, persyaratan, pilihan kelas, dan jadwal PPDB masih perlu disesuaikan.
- Form saat ini menerima pendaftaran tanpa unggah dokumen/berkas. Modul unggah berkas dapat ditambahkan sesuai kebutuhan sekolah.
- Setelah instalasi, ganti password admin demo sebelum digunakan secara publik.
