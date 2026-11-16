<?php $page_title = $page_title ?? 'PPDB Online'; $base = (strpos($_SERVER['SCRIPT_NAME'] ?? '', '/siswa/') !== false) ? '../' : ''; ?>
<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?> | PPDB Sekolah</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?=$base?>assets/style.css">
</head><body>
<header class="topbar"><div class="container nav-wrap">
<a class="brand" href="<?=$base?>index.php"><span class="brand-mark">S</span><span><b>SEKOLAH</b><small>PPDB ONLINE</small></span></a>
<button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('show')" aria-label="Buka menu">☰</button>
<nav class="nav-links"><a href="<?=$base?>index.php">Beranda</a><a href="<?=$base?>index.php#alur">Alur Pendaftaran</a><a href="<?=$base?>index.php#informasi">Informasi</a><?php if(!empty($_SESSION['siswa_id'])): ?><a href="<?=$base?>siswa/index.php">Dashboard Saya</a><a class="nav-cta" href="<?=$base?>logout.php">Logout</a><?php elseif(!empty($_SESSION['admin_id'])): ?><a href="<?=$base?>admin/index.php">Dashboard Admin</a><a class="nav-cta" href="<?=$base?>logout.php">Logout</a><?php else: ?><a href="<?=$base?>login.php">Login</a><a class="nav-cta" href="<?=$base?>register.php">Daftar Akun <span>↗</span></a><?php endif; ?></nav>
</div></header>
