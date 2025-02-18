<?php
$hostname = 'localhost';
$userdb = 'root';
$passdb = '';
$namedb = 'ukk_todolist';

$koneksi = mysqli_connect($hostname,$userdb,$passdb,$namedb);

if (isset($_POST['add_task'])) {
    $tasks = $_POST['tasks'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $namacategory = $_POST['namacategory'];
    $deskripsi = $_POST['deskripsi'];
    $tanggaldibuat = date('Y-m-d');
    $userid = $_SESSION['userid'];
    $categoriesid = $_POST['categoriesid'];
    

    if (!empty($tasks) && !empty($priority) && !empty($due_date)) {
        mysqli_query($koneksi,"INSERT INTO task VALUES('','$tasks','$priority','$due_date','0')");
        echo "<script>alert('Data Berhasil Disimpan');</script>";
    }else{
        echo "<script>alert('Semua Kolom Harus Diisi!');</script>";
    }
}

if (isset($_GET['complete'])) {
    $id = $_GET['complete'];
    mysqli_query($koneksi, "UPDATE task SET status=1 WHERE id=$id");
    echo "<script>alert('Data Berhasil Diperbarui');</script>";
    header('Location:index.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM task WHERE id=$id");
    echo "<script>alert('Data Berhasil Dihapus');</script>";
    header('Location:index.php');
}

$result = mysqli_query($koneksi,"SELECT * FROM task
ORDER BY status ASC, priority DESC, due_date ASC");
?>