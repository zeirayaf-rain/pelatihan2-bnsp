<?php
require 'config/koneksi.php'; require 'includes/functions.php';
if(empty($_SESSION['siswa_id'])){header('Location: login.php');exit;}
$akun_id=(int)$_SESSION['siswa_id'];
$cek=$conn->prepare('SELECT id FROM pendaftar WHERE akun_siswa_id=? LIMIT 1');$cek->bind_param('i',$akun_id);$cek->execute();if($cek->get_result()->fetch_assoc()){header('Location: siswa/index.php');exit;}
$page_title='Formulir Pendaftaran'; $error=''; $success='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();
 $fields=['nama_lengkap','nisn','tempat_lahir','tanggal_lahir','jenis_kelamin','agama','alamat','asal_sekolah','nama_ayah','nama_ibu','no_whatsapp','email','pilihan_kelas','catatan'];
 $d=[]; foreach($fields as $f) $d[$f]=trim($_POST[$f]??'');
 if(!$d['nama_lengkap']||!$d['tempat_lahir']||!$d['tanggal_lahir']||!$d['jenis_kelamin']||!$d['alamat']||!$d['nama_ayah']||!$d['no_whatsapp']||!$d['pilihan_kelas']) $error='Mohon lengkapi seluruh kolom wajib yang bertanda *.';
 elseif(!preg_match('/^[0-9+()\\- ]{8,20}$/',$d['no_whatsapp'])) $error='Format nomor WhatsApp belum sesuai.';
 elseif($d['email'] && !filter_var($d['email'],FILTER_VALIDATE_EMAIL)) $error='Format email tidak valid.';
 else{
  $no='PPDB-'.date('ym').'-'.strtoupper(bin2hex(random_bytes(3)));
  $st=$conn->prepare("INSERT INTO pendaftar(akun_siswa_id,no_pendaftaran,nama_lengkap,nisn,tempat_lahir,tanggal_lahir,jenis_kelamin,agama,alamat,asal_sekolah,nama_ayah,nama_ibu,no_whatsapp,email,pilihan_kelas,catatan) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $st->bind_param('isssssssssssssss',$akun_id,$no,$d['nama_lengkap'],$d['nisn'],$d['tempat_lahir'],$d['tanggal_lahir'],$d['jenis_kelamin'],$d['agama'],$d['alamat'],$d['asal_sekolah'],$d['nama_ayah'],$d['nama_ibu'],$d['no_whatsapp'],$d['email'],$d['pilihan_kelas'],$d['catatan']);
  try{$st->execute();$_SESSION['flash_success']='Pendaftaran berhasil dikirim dengan nomor '.$no;header('Location: siswa/index.php');exit;}catch(Throwable $e){$error='Pendaftaran belum berhasil disimpan. Silakan coba kembali.';}
 }
}
include 'includes/header.php';
?>
<main class="page"><div class="container"><div class="page-heading"><div class="kicker">FORMULIR ONLINE</div><h1>Pendaftaran peserta didik baru</h1><p>Isi data calon siswa dengan benar. Kolom bertanda * wajib diisi.</p></div>
<?php if($success):?><div class="panel status-result"><div class="auth-logo" style="margin:auto">✓</div><h2>Pendaftaran berhasil dikirim!</h2><p>Catat nomor pendaftaran berikut untuk mengecek status pendaftaran.</p><div class="notice"><b style="font-size:19px;letter-spacing:1px"><?=e($success)?></b></div><p>Gunakan nomor pendaftaran dan nomor WhatsApp orang tua/wali pada halaman cek status.</p><a class="btn btn-primary" href="cek_status.php">Cek Status Pendaftaran</a><a class="btn btn-dark" href="index.php">Kembali ke Beranda</a></div>
<?php else:?>
<?php if($error):?><div class="alert error"><?=e($error)?></div><?php endif;?>
<div class="form-layout"><form class="panel" method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><h2>Data calon peserta didik</h2><p class="panel-intro">Masukkan informasi pribadi calon siswa sesuai dokumen resmi.</p><div class="form-grid">
<div class="field"><label>Nama lengkap calon siswa <span class="required">*</span></label><input name="nama_lengkap" required value="<?=e($_POST['nama_lengkap']??'')?>"></div>
<div class="field"><label>NISN</label><input name="nisn" value="<?=e($_POST['nisn']??'')?>" placeholder="Jika sudah memiliki"></div>
<div class="field"><label>Tempat lahir <span class="required">*</span></label><input name="tempat_lahir" required value="<?=e($_POST['tempat_lahir']??'')?>"></div>
<div class="field"><label>Tanggal lahir <span class="required">*</span></label><input type="date" name="tanggal_lahir" required value="<?=e($_POST['tanggal_lahir']??'')?>"></div>
<div class="field"><label>Jenis kelamin <span class="required">*</span></label><select name="jenis_kelamin" required><option value="">Pilih jenis kelamin</option><option>Laki-laki</option><option>Perempuan</option></select></div>
<div class="field"><label>Agama</label><select name="agama"><option value="">Pilih agama</option><?php foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $a):?><option><?=e($a)?></option><?php endforeach;?></select></div>
<div class="field"><label>Asal TK/sekolah</label><input name="asal_sekolah" value="<?=e($_POST['asal_sekolah']??'')?>"></div>
<div class="field"><label>Pilihan kelas <span class="required">*</span></label><select name="pilihan_kelas" required><option value="">Pilih kelas</option><?php foreach(['Kelas 1','Kelas 2','Kelas 3','Kelas 4','Kelas 5','Kelas 6'] as $k):?><option><?=e($k)?></option><?php endforeach;?></select></div>
</div><div class="field"><label>Alamat lengkap <span class="required">*</span></label><textarea name="alamat" required><?=e($_POST['alamat']??'')?></textarea></div>
<h2 style="margin-top:25px">Data orang tua / wali</h2><p class="panel-intro">Nomor WhatsApp digunakan admin untuk menghubungi orang tua/wali.</p><div class="form-grid">
<div class="field"><label>Nama ayah/wali <span class="required">*</span></label><input name="nama_ayah" required value="<?=e($_POST['nama_ayah']??'')?>"></div>
<div class="field"><label>Nama ibu</label><input name="nama_ibu" value="<?=e($_POST['nama_ibu']??'')?>"></div>
<div class="field"><label>Nomor WhatsApp <span class="required">*</span></label><input name="no_whatsapp" required placeholder="Contoh: 081234567890" value="<?=e($_POST['no_whatsapp']??'')?>"></div>
<div class="field"><label>Email orang tua</label><input type="email" name="email" value="<?=e($_POST['email']??'')?>"></div>
</div><div class="field"><label>Catatan tambahan</label><textarea name="catatan" placeholder="Informasi tambahan (opsional)"><?=e($_POST['catatan']??'')?></textarea></div><div class="notice">Dengan mengirim formulir ini, orang tua/wali menyatakan bahwa data yang diisi benar dan dapat digunakan untuk proses penerimaan siswa baru.</div><button class="btn btn-primary" type="submit">Kirim Pendaftaran ↗</button></form>
<aside class="side-info"><h3>Periksa sebelum mengirim</h3><p>Pastikan informasi yang dimasukkan sudah benar agar proses verifikasi berjalan lancar.</p><ul><li>Gunakan nama sesuai dokumen resmi.</li><li>Pastikan tanggal lahir sudah benar.</li><li>Gunakan nomor WhatsApp yang aktif.</li><li>Simpan nomor pendaftaran setelah berhasil.</li></ul><hr style="border-color:#ffffff25;margin:22px 0"><h3>Butuh bantuan?</h3><p>Hubungi pihak sekolah melalui kontak resmi untuk informasi lebih lanjut mengenai persyaratan dan jadwal PPDB.</p></aside></div><?php endif;?></div></main>
<?php include 'includes/footer.php'; ?>
