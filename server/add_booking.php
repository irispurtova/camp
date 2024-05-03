<?php
require '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tel = mysqli_real_escape_string($connect, $_POST['tel']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $nameParent = mysqli_real_escape_string($connect, $_POST['nameParent']);
    $nameChild = mysqli_real_escape_string($connect, $_POST['nameChild']);
    $childAge = mysqli_real_escape_string($connect, $_POST['childAge']);
    $season = mysqli_real_escape_string($connect, $_POST['season']);
    $price = mysqli_real_escape_string($connect, $_POST['price']);
    $name_camp = mysqli_real_escape_string($connect, $_POST['name_camp']);

    if ($tel != '' && $email != '' && $nameParent != '' && $nameChild != '' && $childAge != '') {
        $sql = "INSERT INTO booking (name_camp, telephone, email, name_parent, name_child, child_age, season, price) 
                VALUES ('$name_camp', '$tel', '$email', '$nameParent', '$nameChild', '$childAge', '$season', '$price')";

        if (mysqli_query($connect, $sql)) {
            echo 'Мы свяжемся с Вами в ближайшее время.';
        } else {
            echo 'Error adding booking: ' . mysqli_error($connect);
        }
        
    } else {
        echo 'Введите все данные';
    }
}

mysqli_close($connect);
?>
