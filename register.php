<?php
require "./connection.php";
session_start();

if (isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['register'])) {
    if (!($_POST['password'] === $_POST['password2'])) {
        $error = true;
    } else if (register($_POST)) {
        echo "<script>
            alert('You registered successfully');
            document.location.href = 'login.php';
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            height: 100vh;
            background-color: #beff99;
            background-image:
                radial-gradient(at 5% 59%, hsla(359, 100%, 27%, 1) 0px, transparent 50%),
                radial-gradient(at 95% 30%, hsla(357, 100%, 27%, 1) 0px, transparent 50%),
                radial-gradient(at 50% 29%, hsla(14, 100%, 27%, 1) 0px, transparent 50%),
                radial-gradient(at 90% 75%, hsla(145, 100%, 27%, 1) 0px, transparent 50%),
                radial-gradient(at 33% 93%, hsla(162, 100%, 27%, 1) 0px, transparent 50%),
                radial-gradient(at 19% 96%, hsla(191, 100%, 27%, 1) 0px, transparent 50%),
                radial-gradient(at 73% 34%, hsla(160, 100%, 27%, 1) 0px, transparent 50%);
        }

        .container {
            border-radius: 20px;
        }
    </style>
</head>

<body class="py-5 d-flex">
    <div class="container bg-success m-auto w-50 border py-4">
        <h1 class="text-light mt-3 text-center">Registering Account</h1>
        <form action="" method="post" class="my-3">
            <div class="form-group w-50 m-auto">
                <label class="text-light text-md-start" for="username">Username</label>
                <input class="form-control mb-3 bg-warning text-dark" type="text" id="username" name="username" placeholder="Type Your Username here ..." autofocus required>
            </div>
            <div class="form-group w-50 m-auto">
                <label class="text-light text-md-start" for="password">Password</label>
                <input class="form-control mb-3 bg-warning text-dark" type="password" id="password" name="password" placeholder="Create a strong Password!" required>
            </div>
            <div class="form-group w-50 m-auto">
                <label class="text-light text-md-start" for="password2">Confirm Password</label>
                <input class="form-control mb-3 bg-warning text-dark" type="password" id="password2" name="password2" placeholder="Create a strong Password!" required>
            </div>
            <?php if (isset($error)) : ?>
                <p class="text-danger text-center fw-bold bg-light m-auto mb-3" style="width: 30%;">Password doesn't match!</p>
            <?php endif ?>
            <button class="btn btn-danger d-block m-auto" type="submit" name="register">Register Now!</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>