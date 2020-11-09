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

//ambil data di URL
$id = $_GET["id"];

//query data mahasiswa berdasarkan id
//angka 0 karena data ketika di query berupa array numeric
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

//cek apakah tombol submit sudah diklik apa blm
if( isset($_POST["submit"])){
	//cek apakah data berhasil diubah atau tidak
	if (ubah($_POST) > 0 ){
		//menggunakan contoh script javascript
		echo "
			<script>
				alert('Data berhasil diubah');
				document.location.href = 'index.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Data gagal diubah');
				document.location.href = 'index.php';
			</script>
		";
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Ubah data mahasiswa</title>
</head>

<body>
	<h1>Ubah data mahasiswa</h1>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" required value="<?php echo $mhs["id"];?>">
		<input type="hidden" name="gambarLama" required value="<?php echo $mhs["gambar"];?>">
		<ul>
			<li>
				<label for="nrp">NRP : </label>
				<?#for agar terhubung ke id dan terikat dgn
				#input text?>
				<input type="text" name="nrp" id="nrp" required value="<?php echo $mhs["nrp"];?>">
				<?#name merupakan jenis pada databasenya
					#dan required itu atribut html 5 bahwa user tdk bisa
					#kosongkan itu
					#php echo $mhs["nrp"] untuk mengirimkan data nrp
				?>
			</li> <br>
			<li>
				<label for="nama">Nama : </label>
				<input type="text" name="nama" id="nama" required value="<?php echo $mhs["nama"];?>">
			</li> <br>
			<li>
				<label for="email">Email : </label>
				<input type="text" name="email" id="email" required value="<?php echo $mhs["email"];?>">
			</li> <br>
			<li>
				<label for="jurusan">Jurusan : </label>
				<input type="text" name="jurusan" id="jurusan" required value="<?php echo $mhs["jurusan"];?>">
			</li> <br>
			<li>
				<label for="gambar">Gambar : </label> <br>
				<img src="img/<?php echo $mhs['gambar'];?>" width="40"> <br>
				<input type="file" name="gambar" id="gambar">
			</li> <br>
			<button type="submit" name="submit">Ubah Data</button>
		</ul>
	
	</form>
</body>

</html>