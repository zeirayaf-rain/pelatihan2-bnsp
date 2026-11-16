CREATE DATABASE IF NOT EXISTS db_ppdb_sekolah CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_ppdb_sekolah;
CREATE TABLE IF NOT EXISTS admin (
 id_admin INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) NOT NULL UNIQUE,
 nama_admin VARCHAR(100) NOT NULL,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS akun_siswa (
 id_siswa INT AUTO_INCREMENT PRIMARY KEY,
 nama_lengkap VARCHAR(120) NOT NULL,
 email VARCHAR(120) NOT NULL UNIQUE,
 no_whatsapp VARCHAR(25) NOT NULL,
 password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS pendaftar (
 id INT AUTO_INCREMENT PRIMARY KEY,
 akun_siswa_id INT DEFAULT NULL UNIQUE,
 no_pendaftaran VARCHAR(30) NOT NULL UNIQUE,
 nama_lengkap VARCHAR(120) NOT NULL,
 nisn VARCHAR(20) DEFAULT NULL,
 tempat_lahir VARCHAR(80) NOT NULL,
 tanggal_lahir DATE NOT NULL,
 jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
 agama VARCHAR(30) DEFAULT NULL,
 alamat TEXT NOT NULL,
 asal_sekolah VARCHAR(120) DEFAULT NULL,
 nama_ayah VARCHAR(120) NOT NULL,
 nama_ibu VARCHAR(120) DEFAULT NULL,
 no_whatsapp VARCHAR(25) NOT NULL,
 email VARCHAR(120) DEFAULT NULL,
 pilihan_kelas VARCHAR(30) NOT NULL,
 catatan TEXT DEFAULT NULL,
 status ENUM('Menunggu Verifikasi','Dalam Verifikasi','Lolos','Tidak Lolos') NOT NULL DEFAULT 'Menunggu Verifikasi',
 catatan_admin TEXT DEFAULT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 INDEX idx_status(status), INDEX idx_nama(nama_lengkap), INDEX idx_hp(no_whatsapp)
) ENGINE=InnoDB;
-- Admin demo akan dibuat otomatis oleh config/koneksi.php saat website pertama kali dibuka.
-- Username: adminppdb | Password: AdminPPDB#2026
