<?php
declare(strict_types=1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_ppdb_sekolah';
try {
    $conn = new mysqli($host, $user, $pass);
    $conn->set_charset('utf8mb4');
    $conn->query("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->select_db($db);
    $conn->query("CREATE TABLE IF NOT EXISTS admin (
        id_admin INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        nama_admin VARCHAR(100) NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    $conn->query("CREATE TABLE IF NOT EXISTS akun_siswa (
        id_siswa INT AUTO_INCREMENT PRIMARY KEY,
        nama_lengkap VARCHAR(120) NOT NULL,
        email VARCHAR(120) NOT NULL UNIQUE,
        no_whatsapp VARCHAR(25) NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    $conn->query("CREATE TABLE IF NOT EXISTS pendaftar (
        id INT AUTO_INCREMENT PRIMARY KEY,
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
    ) ENGINE=InnoDB");
    // Relasikan satu akun siswa dengan satu formulir pendaftaran (mendukung database lama).
    $col = $conn->query("SHOW COLUMNS FROM pendaftar LIKE 'akun_siswa_id'");
    if ($col->num_rows === 0) {
        $conn->query("ALTER TABLE pendaftar ADD akun_siswa_id INT DEFAULT NULL UNIQUE AFTER id");
    }
    // Akun demo dibuat otomatis; password disimpan sebagai hash.
    $username = 'adminppdb';
    $hash = password_hash('AdminPPDB#2026', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO admin(username,nama_admin,password_hash) VALUES(?,?,?) ON DUPLICATE KEY UPDATE username=username");
    $nama = 'Administrator PPDB';
    $stmt->bind_param('sss', $username, $nama, $hash);
    $stmt->execute();
    // Akun calon siswa demo dibuat otomatis untuk pengujian.
    // Password juga disimpan dalam bentuk hash, bukan teks biasa.
    $demoEmail = 'calon@demo.test';
    $demoName = 'Calon Siswa Demo';
    $demoPhone = '081234567890';
    $demoPasswordHash = password_hash('CalonSiswa#2026', PASSWORD_DEFAULT);
    $studentStmt = $conn->prepare("INSERT INTO akun_siswa(nama_lengkap,email,no_whatsapp,password_hash) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE email=email");
    $studentStmt->bind_param('ssss', $demoName, $demoEmail, $demoPhone, $demoPasswordHash);
    $studentStmt->execute();
} catch (Throwable $e) {
    http_response_code(500);
    exit('Koneksi/database gagal. Pastikan MySQL pada XAMPP sudah aktif. Detail: ' . htmlspecialchars($e->getMessage()));
}
