<?php
session_start();
$hostname = 'localhost';
$userdb = 'root';
$passdb = '';
$namedb = 'ukk_todolist';

$koneksi = mysqli_connect($hostname,$userdb,$passdb,$namedb);

if (isset($_POST['tambahct'])) {
    $namacategory = $_POST['namacategory'];
    $deskripsi = $_POST['deskripsi'];
    $tanggaldibuat = date('Y-m-d');
    $userid = $_SESSION['userid'];

    $sql = mysqli_query($koneksi, "INSERT INTO categories VALUES('',
    '$namacategory','$deskripsi','$tanggaldibuat','$userid')");

    echo "<script>
    alert('Data Berhasil disimpan!');
    location.href='../admin/categories.php';
    </script>";
}


if (isset($_GET['delete'])) {
    $categoriesid = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM category WHERE categoriesid=$categoriesid");
    echo "<script>alert('Data Berhasil Dihapus');</script>";
    header('Location:index.php');
}

?>