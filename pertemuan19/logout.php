<?php 

//aktifkan session
session_start();

//dipastikan lagi agar var sessionnya disini kosong
$_SESSION = [];

//digunakan utk hilangkan session
//krn ada kassus sudah didestroy tp msh ada session
session_unset();

//menghapus / menghilangkan session
session_destroy();

setcookie('id','',time() -3600);
setcookie('key','',time() -3600);

//didirect ke hal login
header("Location: login.php");
exit;

?>