<?php

//aktifkan session
session_start();

//cek apakah user udah login apa blm, menggunakan session
//dicek bila ga ada $_session login, brrti user blm login
if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'function.php';
//menghubungkan ke file function.php

//pagination
//konfigurasi
//data yg mau ditampilkan perhalaman
$jumlahDataPerhalaman = 2;
//hitung jumlah data dalam database
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
//var halaman aktif adalah halaman yg sdg kita guanakan
//menggunakan operator ternary
//jika halaman aktif ada isinya yg diisi lewat url (?)
$halamanAktif =  (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;

//data awal untuk menentukan datanya dimulai dari nmr brp
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;


$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerhalaman");
//variabel mahasiswa yg mengambil function query

//tombol cari ditekan
//sesuaikan method dan nama yg digunakan untuk tombol cari 
//method post ditangkap dengan $_POST
if(isset($_POST["cari"])){
	$mahasiswa = cari($_POST["keyword"]);
	//dimana var mahasiswa berisi function cari
	//yang datanya didapat dari $_POST berisi keyword yg dikirim user
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>
</head>
<body>
	
	<a href="logout.php">Logout</a>

	<h1>Daftar Mahasiswa</h1>
	
	<a href="tambah.php">Tambah data mahasiswa</a>
	<br><br>
	
	<form action="" method="POST">
		
		<input type="text" name="keyword" size="40" autofocus 
		placeholder="Masukkan keyword pencarian..." 
		autocomplete="off">
		<button type="submit" name="cari">Cari</button>
		
	</form>
	<br><br>

	<!-- navigasi -->

	<?php if($halamanAktif > 1) : ?>
		<a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
	<?php endif; ?>

	<?php for( $i=1; $i <= $jumlahHalaman; $i++) : ?>
		<?php if ($i == $halamanAktif) : ?>
			<a href="?halaman=<?php echo $i; ?>" style="font-weight:bold; color:red;" ><?php echo $i; ?></a>
		<?php else : ?>
			<a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
		<?php endif; ?>
	<?php endfor; ?>
	
	<?php if($halamanAktif < $jumlahHalaman) : ?>
		<a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
	<?php endif; ?>
	
	<br>
	
	<table border="1" cellpadding="10" cellspacing="0">
	
		<tr>
			<th>No</th>
			<th>Aksi</th>
			<th>Gambar</th>
			<th>NRP</th>
			<th>Nama</th>
			<th>Email</th>
			<th>Jurusan</th>
		</tr>
		
		<?php $i = 1; ?>
		<?php foreach ($mahasiswa as $mhs): ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td>
				<a href = "ubah.php?id=<?php echo $mhs["id"];?>">Ubah</a>
				<a href = "hapus.php?id=<?php echo $mhs["id"];?>" onclick="return confirm('Apakah anda yakkin?');">Hapus</a>
			</td>
			<td><img src="img/<?php echo $mhs["gambar"];?>" width="50"></td>
			<td><?php echo $mhs["nrp"]; ?></td>
			<td><?php echo $mhs["nama"]; ?></td>
			<td><?php echo $mhs["email"]; ?></td>
			<td><?php echo $mhs["jurusan"]; ?></td>
		</tr>
		<?php $i++; //agar nomor untuk $i terus bertambah ?>
		<?php endforeach; ?>
	</table>
</body>
</html>