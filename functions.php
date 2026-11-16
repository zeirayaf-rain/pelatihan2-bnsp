<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function admin_login(): bool { return !empty($_SESSION['admin_id']); }
function require_admin(): void {
    if (!admin_login()) { header('Location: login.php'); exit; }
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Sesi formulir tidak valid. Muat ulang halaman dan coba kembali.');
    }
}
function badge_class(string $status): string {
    return match($status) {
        'Lolos' => 'success', 'Tidak Lolos' => 'danger',
        'Dalam Verifikasi' => 'info', default => 'warning'
    };
}
