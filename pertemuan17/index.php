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

$mahasiswa = query("SELECT * FROM mahasiswa");
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