<?php
session_start();
include 'koneksi.php';

//ambil data dari form login
$email = $_POST['email'];
$password = $_POST['password'];

// if ($_POST['submit'] == 'submit') {
//     echo "<script> console.log('Already click!!') </script>";
// }

$data = mysqli_query($koneksi, "select * from user where Email ='$email' and Password = '$password'");

$cek = mysqli_num_rows($data);
if ($cek > 0) {
    $_SESSION['email'] = $email;
    $_SESSION['status'] = "login";
    header("location:admin/index.php");
} else {
    header("location:index.php?pesan=gagal");
}
