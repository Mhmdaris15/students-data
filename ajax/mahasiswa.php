<?php
require '../connection.php';

sleep(1);

$query = "SELECT * FROM mahasiswa";
$students = query(
    'SELECT * FROM mahasiswa WHERE 
    nama LIKE "%' . $_GET['searchbox'] . '%"' . ' OR '
        . 'nrp LIKE "%' . $_GET['searchbox'] . '%"' . ' OR '
        . 'email LIKE "%' . $_GET['searchbox'] . '%"' . ' OR '
        . 'jurusan LIKE "%' . $_GET['searchbox'] . '%"' . ' OR '
        . 'gambar LIKE "%' . $_GET['searchbox'] . '%"'
);

?>

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