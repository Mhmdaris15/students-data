<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
setcookie('id', 'true', time() - 1);
setcookie('key', 'true', time() - 1);
header('Location: login.php');
