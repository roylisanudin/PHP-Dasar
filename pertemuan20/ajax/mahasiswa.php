<?php 

//panggil functuin.php tanda .. keluar dari folder ajax, krn ada diluar filenya
require '../function.php';

//tangkap keyword yg dikirim oleh ajax
$keyword = $_GET["keyword"];

//bkin var query yg isinya select dr dbms setiap ketik keyword 1 x langsung dicari didatabase
$query = "SELECT * FROM mahasiswa WHERE
				nama LIKE '$keyword%' OR
				nrp LIKE '$keyword%' OR
				email LIKE '$keyword%' OR
				jurusan LIKE '$keyword%'
				";

//buat var mahasiswa yg ngelakukan fungsi query dari var query
$mahasiswa = query($query);

?>

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