<?php
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Главная</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <div class="head">
        <div class="admin-header">
            <div class="logo"><img src="../images/logo-white.jpeg" alt="logo" width="49px"></div>
            <div class="welcome">
                Добро пожаловать, Администратор
            </div>
            <div class="bye">
                <a href="../auth/unlog.php">Выйти</a>
            </div>
        </div>
    </div>    

    <div class="table-action">
        <div class="container">
            <div class="block-action">
                <a href="bd.php">Открыть базу лагерей</a>
            </div>
            <div class="block-action">
                <a href="booking.php">Открыть заявки</a>
            </div>
            <div class="block-action">
                <a href="change-categories.php">Изменить категории</a>
            </div>
            <div class="block-action">
                <a href="feedback_admin.php">Модерация отзывов</a>
            </div>
        </div>
    </div>
</body>
</html>