<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Data</title>
</head>

<body>
    <?php
    require './connection.php';
    if (isset($_GET['id'])) {
        if (delete_data($_GET['id']) > 0) {
            echo "<h1>Data berhasil dihapus</h1>";
            echo "<script>alert('Data has been deleted!');
            document.location.href = 'table.php';
            </script>";
        }
    } else {
        echo "<h1>There is no Data that can be deleted!</h1>
        <script>document.location.href = 'table.php'</script>
        ";
    }
    ?>
</body>

</html>