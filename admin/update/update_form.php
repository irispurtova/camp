<?php
require '../../connect.php';

$campid = mysqli_real_escape_string($connect, $_POST["id"]);
$name = mysqli_real_escape_string($connect, $_POST["name"]);
$country = mysqli_real_escape_string($connect, $_POST["country"]);
$region = mysqli_real_escape_string($connect, $_POST["region"]);
$city = mysqli_real_escape_string($connect, $_POST["city"]);
$category = mysqli_real_escape_string($connect, ($_POST['category']) ? implode(" ", $_POST['category']) : "");
$age_from = mysqli_real_escape_string($connect, $_POST["age_from"]);
$age_to = mysqli_real_escape_string($connect, $_POST["age_to"]);
$desc_card = mysqli_real_escape_string($connect, $_POST["desc_card"]);
$description = mysqli_real_escape_string($connect, $_POST['description']);

$sql = "UPDATE camps SET 
    name = '$name', 
    country = '$country', 
    region = '$region', 
    city = '$city', 
    category = '$category', 
    age_from = '$age_from', 
    age_to = '$age_to', 
    desc_card = '$desc_card', 
    description = '$description' 
    WHERE id = $campid";

if (isset($_POST["Зимний_price"])) {
    $season1 = mysqli_real_escape_string($connect, $_POST["Зимний_price"]);
    $sql1 = "UPDATE price SET name = '$name', price = '$season1' WHERE (season='Зимний' AND id_camp='$campid')";
    mysqli_query($connect, $sql1);
}
if (isset($_POST["Весенний_price"])) {
    $season2 = mysqli_real_escape_string($connect, $_POST["Весенний_price"]);
    $sql2 = "UPDATE price SET name = '$name', price = '$season2' WHERE (season='Весенний' AND id_camp='$campid')";
    mysqli_query($connect, $sql2);
}
if (isset($_POST["Летний_price"])) {
    $season3 = mysqli_real_escape_string($connect, $_POST["Летний_price"]);
    $sql3 = "UPDATE price SET name = '$name', price = '$season3' WHERE (season='Летний' AND id_camp='$campid')";
    mysqli_query($connect, $sql3);
}
if (isset($_POST["Осенний_price"])) {
    $season4 = mysqli_real_escape_string($connect, $_POST["Осенний_price"]);
    $sql4 = "UPDATE price SET name = '$name', price = '$season4' WHERE (season='Осенний' AND id_camp='$campid')";
    mysqli_query($connect, $sql4);
}

if (mysqli_query($connect, $sql)) {    
    echo "Данные успешно обновлены";
} else {
    echo "Ошибка при обновлении данных: " . mysqli_error($connect);
}

mysqli_close($connect);
?>