<?php
session_start();
include '../config/koneksi.php';
$koneksi = mysqli_connect('localhost', 'root', '', 'ukk_todolist');
$userid = $_SESSION['userid'];
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda belum Login!');
    location.href='../index.php';
    </script>";
};

$profile = mysqli_query($koneksi, "SELECT t.id FROM users WHERE 
t.username, t.email, t.nama");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>To Do List App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="view/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
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
                
                </div>
                <a href="../config/aksi_logout.php" class="btn btn-outline-light btn-secondary m-1">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="card mt-5" style="width: 30rem;">
            <ul class="list-group list-group-flush">
                <?php
            
                $userid = $_SESSION['userid'];
                $sql = mysqli_query($koneksi, "SELECT * FROM users 
                            WHERE userid='$userid'");
                while ($data = mysqli_fetch_array($sql)) {
                    $username = $data['username'];
                    $nama = $data['nama'];
                    $email = $data['email']
                    
                ?>
                    <li class="list-group-item">Username : <?php echo $data['username'] ?> </li>
                    <li class="list-group-item">Nama : <?php echo $data['nama'] ?></li>
                    <li class="list-group-item">Email : <?php echo $data['email'] ?></li>
            </ul>
            <a href="index.php" class="btn btn-outline-light btn-secondary m-2 w-50">Back</a>
        </div>
    </div>
<?php }
                        
                    
                    ?>
                        

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p class="mt-3">&copy; UKK PPLG 2025 | Ridho Alfath N.</p>
</footer>

<script src="view/js/bootstrap.min.js"></script>
</body>

</html>