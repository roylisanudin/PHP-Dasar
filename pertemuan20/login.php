<?php 

//aktifkan session
session_start();
require 'function.php';

//cek cookie
//karena mau walau sudah diclose browser,jika ada cookie biar ga ush login 2x
//cek cookie jika true ketika mempunyai id dan key (yg kita cek dibawah), session loginnya diset
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil username berdasarkan id
    //dicek id yg diinput / masuk kecookie. dicek ke database
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan username sama atau engga
    // $ key adalah username yg diinput login diacak (hash) sama atau tidak dgn username di dbms yg kita acak juga (hash)
    if ( $key === hash('sha256', $row['username'])) {
        //kalau sama / benar, dia bisa login dan ada cookienya
        $_SESSION['login'] = true;
    }
}

//jika cookie ga ada,dia akan melakukan session biasa
//jika diclose, browsernya hrus login ulang

//cek jika sudah login, ga bisa balik dari index ke login
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}


//cek jika tombol login di klik
if (isset($_POST["login"])) {
    
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");

    //cek usernamenya
    //jika dihitung barisnya cocok dgn username
    //berrti 1 baris ketemu, lalu eksekusi login
    if (mysqli_num_rows($result) === 1 ) {
        
        //cek passwordnya
        //kirim kembalikan data array asso dgn var result
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])){
            
            //set session kalo berhasil login
            $_SESSION["login"] = true;
            
            //cek remember me
            if (isset($_POST['remember'])) {
                //buat cookie dengan meng setnya
                //$row itu dari pengecekan database
                //usernamenya kita ubh namanya key yg dicek di database yaitu username
                //lalu dihash dgn algoritma sha256 (bnyk algoritma di doc php)
                setcookie('id', $row['id'],time()+60);
                setcookie('key', hash('sha256', $row['username']),time()+60);
            }

            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}

?>



<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
</head>
<body>
    <h1>Halaman Login</h1>
    <?php //di ekseskusi jika ada var error dipanggil?>
    <?php if(isset($error)) : ?>
        <p style="color: red; font-style:italic;">Username / Password salah</p>
    <?php endif; ?>

    <form action="" method="POST">
        <ul>
            <li>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            <br>
            <button type="submit" name="login">Login</button>
        </ul>
    </form>
</body>
</html>