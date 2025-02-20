<?php 
session_start();
include '../config/koneksi.php';
$koneksi = mysqli_connect('localhost','root','','ukk_todolist');
$userid = $_SESSION['userid'];

if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
}


if (isset($_POST['add_task'])) {
    $tasks = $_POST['tasks'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $categoriesid = $_POST['categoriesid'];
    $userid = $_SESSION['userid'];

    if (!empty($tasks) && !empty($priority) && !empty($due_date)) {
   
        $sql = mysqli_query($koneksi, "INSERT INTO task VALUES('','$tasks','$priority','$due_date','0','$categoriesid','$userid')");
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

$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = $koneksi->real_escape_string($_POST['search']);
}


$result = mysqli_query($koneksi,"SELECT t.id AS id, t.userid, t.tasks, t.status, t.priority, t.due_date, c.namacategory 
          FROM task t 
          LEFT JOIN categories c ON t.categoriesid = c.categoriesid 
          WHERE c.namacategory LIKE '%$searchTerm%' 
             OR t.tasks LIKE '%$searchTerm%' 
             OR t.userid LIKE '%$searchTerm%' 
          ORDER BY t.status ASC, t.priority DESC, t.due_date ASC");

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

        <a href="/UKK2025_XIIPPLG2_7909/admin/profile.php" class="btn btn-outline-light btn-info m-1">Profile</a>
            <a href="../config/aksi_logout.php" class="btn btn-outline-light btn-secondary m-1">Keluar</a>
            
        </div>
    </div>
</nav>
<div class="container mt-2">
    <h1 class="text-center text-success">To Do List</h1>
    <form action="" method="POST" class="border rounded bg-info p-3 mb-3">
    <label for="" class="form-label">Nama Task</label>
    <input type="text" name="tasks" class="form-control" placeholder="Masukan Task Baru" autocomplete="off" autofocus required>
        <label class="form-label">Categories</label>
        <select name="categoriesid" class="form-control">
        <?php
        $namacategory = $_POST['namacategory'];
        $categoriesid = $_POST['categoriesid'];
        $userid = $_SESSION['userid'];
        $sql_categories = mysqli_query($koneksi, "SELECT * FROM categories WHERE userid='$userid'");
        while ($data_categories = mysqli_fetch_array($sql_categories)) { ?>
        <option value="<?php echo $data_categories['categoriesid'] ?>">
                <?php echo $data_categories['namacategory'] ?>
            </option>
        <?php } ?>
        </select>
        
        <label for="" class="form-label">Prioritas</label>
        <select name="priority" id="" class="form-control" required>
            <option value="">Pilih Prioritas</option>
            <option value="1">Kurang Penting</option>
            <option value="2">Penting</option>
            <option value="3">Sangat Penting</option>
        </select>
        <label for="" class="form-label">Tanggal</label>
        <input type="text" name="due_date" class="form-control"
        value="<?php echo date('Y-m-d') ?>" required>
        <button type="submit" class="btn btn-success w-100 mt-2" name="add_task">Tambah</button>
    </form>
    
    <form method="POST" action="" class="mb-2 d-flex">
    <input class="form-control me-2" type="text" name="search" placeholder="Cari berdasarkan nama task" value="<?php echo htmlspecialchars($searchTerm); ?>">
    <input class="btn btn-success" type="submit" value="Search">
    </form>
    

    <table class="table table-striped table-info">
        <thead>
            <tr>
                <th>No</th>
                <th>Task</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($koneksi, "SELECT * FROM categories 
            WHERE userid='$userid'");
                while ($data = mysqli_fetch_array($sql)) {    
            if (mysqli_num_rows($result) > 0) {
                $no =1;
                while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['tasks']; ?></td>
                    <td><?php echo $row['namacategory']; ?>
                    </td>
                    <td>
                        <?php
                        if ($row['priority'] == 1) {
                            echo "Kurang Penting";
                        }elseif($row['priority'] == 2) {
                            echo "Penting";
                        }else{
                            echo "Sangat Penting";
                        }
                        ?>
                    </td>
                    <td><?php echo $row['due_date']; ?></td>
                    <td> <?php
                    if ($row['status'] == 0) {
                            echo "Belum Selesai";
                        }else{
                            echo "Selesai";
                        }
                        ?></td>
                    <td>
                        <?php
                        if ($row['status'] == 0) { ?>
                        <a href="?complete=<?php echo$row['id'] ?>" class="btn btn-success">Selesai</a>
                        <?php }
                        ?>    
                        <a href="?delete=<?php echo$row['id']?>" class="btn btn-secondary">Hapus</a>
                    </td>
                </tr>
                <?php }
            }
        }
            ?>
            <tr>

            </tr>
        </tbody>
    </table>




    <script src="view/js/bootstrap.min.js"></script>
</body>
</html>