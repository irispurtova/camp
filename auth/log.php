<?php
require '../connect.php';

$login = $_POST['login'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE name_user = '$login' AND pass_user = '$password'";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($login === 'admin' && $password === 'admin') {
        session_start();
        $_SESSION['auth'] = 'admin';
        echo "admin";
    } else {
        session_start();
        $_SESSION['auth'] = 'user';
        echo "user";
    }

} else {
    echo "Неверные данные для входа!";
}

$connect->close();
?>
