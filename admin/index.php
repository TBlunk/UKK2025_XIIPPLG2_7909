<?php 
session_start();
$userid = $_SESSION['userid'];
$koneksi = mysqli_connect('localhost','root','','ukk_todolist');
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

    if (!empty($tasks) && !empty($priority) && !empty($due_date)) {
        mysqli_query($koneksi,"INSERT INTO task VALUES('','$tasks','$priority','$due_date','0')");
        echo "<script>alert('Data Berhasil Disimpan');</script>";
    }else{
        echo "<script>alert('Semua Kolom Harus Diisi!');</script>";
    }
}

$result = mysqli_query($koneksi,"SELECT * FROM task
ORDER BY status ASC, priority DESC, due_date ASC");
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
<div class="container mt-2">
    <h1 class="text-center text-success">To Do List</h1>
    <form action="" method="POST" class="border rounded bg-info p-3 mb-3">
        <label for="" class="form-label">Nama Task</label>
        <input type="text" name="tasks" class="form-control" placeholder="Masukan Task Baru" autocomplete="off" autofocus required>
        <label class="form-label">Categories</label>
        <select name="categoriesid" class="form-control">
        <?php
        $categoriesid = $_POST['categoriesid'];
        $userid = $_SESSION['userid'];
        $sql_categories = mysqli_query($koneksi, "SELECT * FROM categories WHERE userid='$userid'");
        while ($data_categories = mysqli_fetch_array($sql_categories)) { ?>
        <option <?php if($data_categories['categoriesid'] == $data['categoriesid'])
        { ?> selected="selected" <?php } ?>     
        value="<?php echo $data_categories['categoriesid'] ?>">
                <?php echo $data_categories['namacategories'] ?>
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
        <button type="submit" class="btn btn-success w-10 mt-3" name="add_task">Tambah</button>
    </form>

    

    <table class="table table-striped">
        <thead class="table-info">
            <tr>
                <th>No</th>
                <th>Task</th>
                <th>Categories</th>
                <th>Priority</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                $no =1;
                while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['tasks']; ?></td>
                    <td></td>
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
                    <td>
                        <?php
                        if ($row['status'] == 0) {
                            echo "Belum Selesai";
                        }else{
                            echo "Selesai";
                        }
                        ?>
                    </td>
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
            ?>
        </tbody>




<footer class="d-flex justify-content-center border-top mt-3 bd-light fixed-bottom" >
    <p class="mt-3">&copy; UKK PPLG | Ridho Alfath N.</p>
</footer>

    <script src="view/js/bootstrap.min.js"></script>
</body>
</html>