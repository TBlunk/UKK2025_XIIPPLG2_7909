<?php 
session_start();
$userid = $_SESSION['userid'];
include '../config/koneksi.php';

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>To Do List App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="view/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container">
    <a class="navbar-brand text-light" href="index.php">To Do List App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNav">
        <div class="navbar-nav me-auto">          
            <a href="categories.php" class="nav-link text-light mb-2">Categories</a>           
        </div>
            <a href="../config/aksi_logout.php" class="btn btn-outline-light btn-secondary m-1">Keluar</a>
        </div>
    </div>
</nav>
<div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header">
                        Tambah Categories
                    </div>
                    <div class="card-body">
                        <form action="../config/aksi_categories.php" method="POST">
                            <label class="form-label">Nama Categories</label>
                            <input type="text" name="namacategory" class="form-control" required>
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" required></textarea>
                            <button type="submit" class="btn btn-success mt-2" name="tambahct">Tambah Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col md-8">
                <div class="card mt-2">
                    <div class="card-header">Data Categories</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Categories</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $userid = $_SESSION['userid'];
                                $sql = mysqli_query($koneksi, "SELECT * FROM categories 
                            WHERE userid='$userid'");
                                while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $data['namacategory'] ?></td>
                                        <td><?php echo $data['deskripsi'] ?></td>
                                        <td><?php echo $data['tanggaldibuat'] ?></td>
                                        <td>

                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapus<?php echo $data['categoriesid'] ?>">
                                                Hapus
                                            </button>
                                            <div class="modal fade" id="hapus<?php echo $data['categoriesid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="../config/aksi_categories.php" method="POST">
                                                                <input type="hidden" name="categoriesid" value="<?php echo $data['categoriesid'] ?>">
                                                                Apakah anda yakin akan menghapus data <strong> <?php echo $data['namacategories'] ?>"
                                                                </strong> ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="hapus" class="btn btn-primary">Hapus Data</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                        </table>
                            
<footer class="d-flex justify-content-center border-top mt-3 bd-light fixed-bottom" >
    <p class="mt-3">&copy; UKK PPLG | Ridho Alfath N.</p>
</footer>

    <script src="view/js/bootstrap.min.js"></script>
</body>
</html>