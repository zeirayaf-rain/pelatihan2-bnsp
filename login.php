<?php
require 'config/koneksi.php';require 'includes/functions.php';
if(admin_login()){header('Location: admin/index.php');exit;} if(!empty($_SESSION['siswa_id'])){header('Location: siswa/index.php');exit;}
$error='';$flash=$_SESSION['flash_success']??'';unset($_SESSION['flash_success']);
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();$identity=trim($_POST['identity']??'');$password=$_POST['password']??'';
 $st=$conn->prepare('SELECT id_admin,nama_admin,password_hash FROM admin WHERE username=? LIMIT 1');$st->bind_param('s',$identity);$st->execute();$a=$st->get_result()->fetch_assoc();
 if($a&&password_verify($password,$a['password_hash'])){session_regenerate_id(true);$_SESSION['admin_id']=$a['id_admin'];$_SESSION['admin_nama']=$a['nama_admin'];header('Location: admin/index.php');exit;}
 $st=$conn->prepare('SELECT id_siswa,nama_lengkap,email,password_hash FROM akun_siswa WHERE email=? LIMIT 1');$st->bind_param('s',$identity);$st->execute();$s=$st->get_result()->fetch_assoc();
 if($s&&password_verify($password,$s['password_hash'])){session_regenerate_id(true);$_SESSION['siswa_id']=$s['id_siswa'];$_SESSION['siswa_nama']=$s['nama_lengkap'];$_SESSION['siswa_email']=$s['email'];header('Location: siswa/index.php');exit;}
 $error='Email/username atau password tidak sesuai.';
}
$page_title='Login';include 'includes/header.php';?>
<main class="auth-wrap"><form class="auth-card" method="post"><div class="auth-logo">S</div><div class="kicker" style="margin-top:22px">AREA PENGGUNA</div><h1>Selamat datang kembali</h1><p>Login sebagai calon siswa menggunakan email, atau sebagai admin menggunakan username.</p><?php if($flash):?><div class="alert success"><?=e($flash)?></div><?php endif;?><?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><div class="field"><label>Email siswa / Username admin</label><input name="identity" required autocomplete="username" placeholder="Email atau username"></div><div class="field"><label>Password</label><input type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password"></div><button class="btn btn-primary" style="width:100%">Login ↗</button><p style="margin-top:18px;text-align:center">Belum punya akun siswa? <a href="register.php" class="action-link">Daftar akun</a></p><p style="text-align:center"><a href="index.php" class="action-link">← Kembali ke website</a></p></form></main><?php include 'includes/footer.php';?>
