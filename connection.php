<?php

$conn = mysqli_connect('localhost', 'root', '', 'phpdasar');

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function add($data)
{
    global $conn;
    $nama = htmlspecialchars($data['name']);
    $nrp = htmlspecialchars($data['nrp']);
    $email = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);
    // $gambar = htmlspecialchars($data['gambar']);
    $gambar = upload();
    $query = "INSERT INTO mahasiswa VALUES ('','$nama','$nrp','$email','$jurusan','$gambar')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function delete_data($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");
    return mysqli_affected_rows($conn);
}

function update_data($data)
{
    global $conn;
    $id = htmlspecialchars($data['id']);
    $nama = htmlspecialchars($data['name']);
    $nrp = htmlspecialchars($data['nrp']);
    $email = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $gambarLama = htmlspecialchars($data['gambar']);

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    mysqli_query($conn, "UPDATE mahasiswa SET
        nama='$nama',
        nrp='$nrp',
        email='$email',
        jurusan='$jurusan',
        gambar='$gambar'
        WHERE id=$id;
    ");
    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    $path = "img/";
    $path = $path . $namaFile;
    if ($error === 4) {
        echo "<script>
            alert('Please choose a file');
        </script>";
        return false;
    }

    // Make sure the file is an image
    $fileExtensionAllowed = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
    $fileExtension = explode('.', $namaFile);
    $fileExtension = strtolower(end($fileExtension));
    if (!in_array($fileExtension, $fileExtensionAllowed)) {
        echo "<script>
            alert('Please choose a file with extension jpg, jpeg, png, gif, bmp, svg, webp');
        </script>";
        return false;
    }

    if ($ukuranFile > 1000000) {
        echo "<script>
            alert('File is too big');
        </script>";
        return false;
    }

    $newFileName = uniqid();
    $newFileName = $newFileName . "." . $fileExtension;
    $path = "img/" . $newFileName;


    if (move_uploaded_file($tmpName, $path)) {
        return $newFileName;
    } else {
        echo "<script>
            alert('Upload failed');
            document.location.href = 'table.php';   
        </script>";
        return false;
    }
}

function register($data)
{
    global $conn;

    $username = strtolower(stripslashes(htmlspecialchars($data['username']))); // missing the undesired characters and lowercase the string
    // check if the username is already taken
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Username already exists');
    </script>";
        return false;
    }

    // Password must contain at least 5 characters, must consists of number and letters
    if (strlen(htmlspecialchars($data['password'])) < 5) {
        echo "<script>
            alert('Password must contain at least 5 characters');
        </script>";
        return false;
    }
    $password = password_hash($data['password'], PASSWORD_DEFAULT); // hash the password using the default algorithm

    // insert the data into the database
    $query = "INSERT INTO users VALUES ('','$username','$password')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function login($data)
{
    global $conn;

    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($result) === 1) {
        $result = mysqli_fetch_assoc($result);

        if (password_verify($password, $result['password'])) {
            setcookie('id', $result['id'], time() + 3600);
            setcookie('key', hash('sha256', $username), time() + 3600);
            $_SESSION['login'] = true;
            return [true, ''];
        } else {
            return [false, 'Your Credential is invalid!'];
        }
    } else {
        return [false, "Account doesn't exist!"];
    }
}
