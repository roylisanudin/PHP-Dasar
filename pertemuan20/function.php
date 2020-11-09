<?php
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
	global $conn;
	//membuat variabel result yang memiliki fungsi ambil data 
	//dari tabel yaitu mysqli_query (koneksi dtbse, parameter)
	$result = mysqli_query($conn, $query);
	//membuat variabel kosong untuk wadahnya
	$rows = [];
	//membuat variabel row yg memiliki fungsi mengambil data
	//dari result/dtbse dengan array assosiatif
	while ($row = mysqli_fetch_assoc($result)){
		//dimana setiap data yg diambil diisi pada variabel rows
		$rows[] = $row;
	}
	//mengembalikan nilai rows
	return $rows;
}

//funtion tambah menerima inputan berupa $data
function tambah($data){
	global $conn;
	
	$nrp = htmlspecialchars($data["nrp"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);
	
	//upload gambar
	$gambar = upload();
	if (!$gambar){
		return false;
	}
	
	//bikin variabel query yg isinya insert data
	//data yg mau diinsert harus berurut seperti di DBMS
	$query = "INSERT INTO mahasiswa VALUES ('','$nama','$nrp','$email','$jurusan','$gambar')";
	
	//lakukan fungsi query ke dbms
	//yg didalam nya manggil variabel conn (koneksinya) dan query (cara insertnya)
	mysqli_query($conn, $query);
	
	//mengembalikan nilai jika gagal= -1 atau berhasil= +1
	//pada variabel conn /ketika input data ke database
	return mysqli_affected_rows($conn);
	
}

function upload(){
	//membuat variabel baru yg ditangkap dengan $_FILES
	//karena di tambah.php menggunakan type file dan name pada tambah.php
	//adalah gambar -> name="gambar"
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];
	
	//cek apakah tidak ada gambar yang diupload
	//angka 4 adalah error pada file jika tidak mengupload
	if ( $error === 4 ){
		echo "<script>
				alert('Pilih gambar terlebih dahulu!');
			</script>";
		return false;
	}
	
	//cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = explode('.',$namaFile);
	//explode memecah namafile menjadi array, dengan menghapus tanda "."
	//contoh sandika.jpg menjadi ['sandika','jpg']
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	//end mengambil array terakhir dari ekstensiGambar
	//strtolower mengubah tulisan arraynya dari huruf besar ke huruf kecil semua
	if(!in_array($ekstensiGambar,$ekstensiGambarValid)){
	//kalaau tak ada ekstensi yg cocok didalam gambar dengan valid
	//eksekusi demikian
		echo "<script>
				alert('Maap yang anda masukkan bukan gambar!');
			</script>";
		return false;
	}
	
	//cek jika ukurannya terlalu besar (satuan bite)
	if ($ukuranFile > 1000000 ){
		echo "<script>
				alert('Maap ukuran gambar terlalu besar!');
			</script>";
		return false;
	}
	
	//lolos pengecekan, gambar siap diupload
	//generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	
	move_uploaded_file($tmpName,'img/'.$namaFileBaru);
	return $namaFileBaru;
}

function hapus($id){
	//function hapus yang menerima data $id
	global $conn;
	//konek dbms
	mysqli_query($conn,"DELETE FROM mahasiswa WHERE id = $id");
	//menjalankan query database (koneksi,perintah)

	return mysqli_affected_rows($conn);
	//agar mengembalikan nilai dari dtbase bhwa data berhasil diubah atau tidak 
	//(databasenya berubah)
}

function ubah($data){
	global $conn;
	
	$id = $data["id"];
	//menangkap id yang dikiripkan pada ubah.php
	$nrp = htmlspecialchars($data["nrp"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);
	
	$gambarLama= htmlspecialchars($data["gambarLama"]);
	//gambar lama dari ubah.php
	
	//cek apakah user pilih gambar baru atau tidak
	//jika gambar dan error sama dengan 4 (4 nilai error/tdk ada upload)
	//maka eksekusi
	if ($_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	} else {
		//jika gagal $gambar menjalankan function upload
		$gambar = upload();
	}
	
	$query = "UPDATE mahasiswa SET
				nama = '$nama',
				nrp = '$nrp',
				email = '$email',
				jurusan = '$jurusan',
				gambar = '$gambar'
			 WHERE id = $id
			";
	
	mysqli_query($conn, $query);
	
	return mysqli_affected_rows($conn);
	
}

function cari($keyword){
	//mengubah nama like (menyerupai) keyword% apapun lanjutan dibelakang textnya 
	$query = "SELECT * FROM mahasiswa WHERE
				nama LIKE '$keyword%' OR
				nrp LIKE '$keyword%' OR
				email LIKE '$keyword%' OR
				jurusan LIKE '$keyword%'
				";
	return query($query);
	//memanggil function query yg sudah dibuat didalem function baru
}

function registrasi($data){
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	//cek username sudah ada atau belum
	//query terlebih dahulu ketabel user
	//masukan atau buat di variabel result saja
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
				alert('Username sudah terdaftar!');
			</script>";
		return false;
	}
	
	//cek konfirmasi password
	if($password !== $password2) {
		echo "<script>
				alert('Konfirmasi password tidak sesuai!');
			</script>";
		return false;
	}

	//enkripsi password
	$password = password_hash($password,PASSWORD_DEFAULT);

	//tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO user VALUES ('','$username','$password')");

	return mysqli_affected_rows($conn);

}
?>