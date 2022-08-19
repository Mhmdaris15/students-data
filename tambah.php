<?php
session_start();
require './connection.php';

// Cookie Login
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
    $result = mysqli_fetch_assoc($result);
    $new_key = hash('sha256', $result['username']);
    if ($key !== $new_key) {
        header('Location: login.php');
        exit;
    }
} else if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {
    if (add($_POST) > 0) {
        echo "<script>
            alert('Data berhasil dimasukkan');
            document.location.href = 'table.php';
        </script>";
    } else {
        echo "
        <script>
        alert('There is error here')
        document.location.href = 'table.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Add Data</title>
</head>

<body class="bg-success">
    <h1 class="text-center">Add a new Data</h1>
    <form action="" method="post" enctype="multipart/form-data" class="w-50 m-auto d-flex justify-content-md-around flex-wrap">
        <div>
            <label for="name">Name</label>
            <input class="form-control" type="text" id="name" name="name" required><br>
        </div>
        <div>
            <label for="nrp">NRP</label>
            <input class="form-control" type="text" id="nrp" name="nrp" required><br>
        </div>
        <div>
            <label for="email">Email</label>
            <input class="form-control" type="text" id="email" name="email" required><br>
        </div>
        <div>
            <label for="jurusan">Jurusan</label>
            <input class="form-control" type="text" id="jurusan" name="jurusan" required><br>
        </div>
        <div>
            <label for="gambar">Gambar</label>
            <input class="form-control" type="file" id="gambar" name="gambar" required><br>
        </div>
        <div>
            <button class="btn btn-danger m-auto" id="submit" name="submit">Submit</button>
        </div>
    </form>
</body>

</html>