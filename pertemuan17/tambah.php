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
//cek apakah tombol submit sudah diklik apa blm
if( isset($_POST["submit"])){
	
	
	//cek apakah data berhasil ditambah atau tidak
	if (tambah($_POST) > 0 ){
		//menggunakan contoh script javascript
		echo "
			<script>
				alert('Data berhasil ditambahkan');
				document.location.href = 'index.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data gagal ditambahkan');
				document.location.href = 'index.php';
			</script>
		";
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Tambah data mahasiswa</title>
</head>

<body>
	<h1>Tambah data mahasiswa</h1>
	<form action="" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="nrp">NRP : </label>
				<?#for agar terhubung ke id dan terikat dgn
				#input text?>
				<input type="text" name="nrp" id="nrp" required>
				<?#name merupakan jenis pada databasenya
					#dan required itu atribut html 5 bahwa user tdk bisa
					#kosongkan itu
				?>
			</li> <br>
			<li>
				<label for="nama">Nama : </label>
				<input type="text" name="nama" id="nama" required>
			</li> <br>
			<li>
				<label for="email">Email : </label>
				<input type="text" name="email" id="email" required>
			</li> <br>
			<li>
				<label for="jurusan">Jurusan : </label>
				<input type="text" name="jurusan" id="jurusan" required>
			</li> <br>
			<li>
				<label for="gambar">Gambar : </label>
				<input type="file" name="gambar" id="gambar" required>
			</li> <br>
			<button type="submit" name="submit">Tambah Data</button>
			
		</ul>
	
	</form>
</body>

</html>