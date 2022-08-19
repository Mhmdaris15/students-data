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

if (!isset($_POST['search'])) {
    // Configure Pagination 
    $dataNum = count(query('SELECT * FROM mahasiswa'));
    $dataPerPage = 3;
    $pageNum = ceil($dataNum / $dataPerPage);
    $activePage = isset($_GET['page']) ? $_GET['page'] : 1;
    $beginData = ($activePage * $pageNum) - $activePage;
    $students = query("SELECT * FROM mahasiswa LIMIT $beginData, $pageNum");
} else {
    $students = query(
        'SELECT * FROM mahasiswa WHERE 
        nama LIKE "%' . $_POST['searchbox'] . '%"' . ' OR '
            . 'nrp LIKE "%' . $_POST['searchbox'] . '%"' . ' OR '
            . 'email LIKE "%' . $_POST['searchbox'] . '%"' . ' OR '
            . 'jurusan LIKE "%' . $_POST['searchbox'] . '%"' . ' OR '
            . 'gambar LIKE "%' . $_POST['searchbox'] . '%"'
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="./js/jquery.min.js"></script>
    <script src="./js/script.js"></script>

</head>

<body class="p-5">
    <a href="tambah.php" class="btn btn-success my-3">Tambah Data Mahasiswa</a>
    <a href="logout.php" class="btn btn-danger my-3">Logout</a>
    <form action="" method="POST" class="d-flex gap-3 mb-3">
        <input class="form-control w-50" type="text" name="searchbox" id="searchbox" placeholder="Search what Data" autofocus autocomplete="off">
        <button class="btn btn-success" type="submit" name="search" id="search-btn">Search</button>
        <img src="./img/Gold coin Bitcoin.gif" id="loader" style="width: 4%;">
    </form>
    <?php if (isset($activePage)) : ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= ($activePage <= 1) ? 'disabled' : '' ?>"><a class="page-link " href="?page=<?= $activePage - 1 ?>">Previous</a></li>
                <?php for ($i = 1; $i <= $pageNum; $i++) : ?>
                    <li class="page-item <?= ($i == $activePage) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor ?>
                <li class="page-item  <?= ($activePage >= $pageNum) ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $activePage + 1 ?>">Next</a></li>
            </ul>
        </nav>
    <?php endif ?>
    <div class="container" id="container">
        <table border="1" class="mb-3">
            <tr class="bg-warning p-3">
                <th class="p-3 text-center border border-secondary">No.</th>
                <th class="p-3 text-center border border-secondary">Nama</th>
                <th class="p-3 text-center border border-secondary">NRP. </th>
                <th class="p-3 text-center border border-secondary">Email</th>
                <th class="p-3 text-center border border-secondary">Jurusan</th>
                <th class="p-3 text-center border border-secondary">Gambar</th>
                <th class="p-3 text-center border border-secondary">Action</th>
            </tr>
            <?php $i = 1;
            foreach ($students as $student) : ?>
                <tr>
                    <td class="p-4 border border-secondary"><?= $i ?></td>
                    <td class="p-4 border border-secondary"><?= $student['nama'] ?></td>
                    <td class="p-4 border border-secondary"><?= $student['nrp'] ?></td>
                    <td class="p-4 border border-secondary"><?= $student['email'] ?></td>
                    <td class="p-4 border border-secondary"><?= $student['jurusan'] ?></td>
                    <td class="p-4 border border-secondary"><img src="img/<?= $student['gambar'] ?>" width="150" alt="<?= $student['nama'] ?>"></td>
                    <td class="p-4 border-top border-secondary d-flex flex-column gap-2">
                        <a href="update.php?id=<?= $student['id'] ?>" type="button" class="btn btn-success">Ubah</a>
                        <a href="hapus.php?id=<?= $student['id'] ?>" type="button" class="btn btn-danger" onclick="return confirm('Are you sure Delete this Data?')">Hapus</a>
                    </td>
                </tr>
            <?php $i++;
            endforeach ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>