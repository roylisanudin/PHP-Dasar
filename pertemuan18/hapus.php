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

$id = $_GET["id"];
//id yg dikirimkan lewat a href, ditangkep dgn var superglobal
//$_GET yaitu id dimasukkan ke var. id

if ( hapus($id) > 0 ){
	//memanggil function hapus dengan mengirimkan id di file function.php,
	//dengan perumpaan sama seperti jika +1 data berubah berrti berhasil
	echo "
		<script>
			alert('Data berhasil dihapus');
			document.location.href = 'index.php';
		</script>
	";
} else {
	echo "
		<script>
			alert('Data gagal dihapus');
			document.location.href = 'index.php';
		</script>
	";
}
?>