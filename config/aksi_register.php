<?php
include'koneksi.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = md5($_POST['password']);



$sql = mysqli_query($koneksi, "INSERT INTO users VALUES ('',
'$username', '$email', '$password')");

if ($sql) {
    echo "<script>
    alert('Pendaftaran akun berhasil')
    location.href='../login.php';
    </script>";
}

?>