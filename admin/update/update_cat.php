<?php
require '../../connect.php';

$campid = mysqli_real_escape_string($connect, $_POST["id"]);
$name = mysqli_real_escape_string($connect, $_POST["name"]);

$sql = "UPDATE categories SET category = '$name' WHERE id_cat = $campid";

if (mysqli_query($connect, $sql)) {    
    echo "Данные успешно обновлены";
} else {
    echo "Ошибка при обновлении данных: " . mysqli_error($connect);
}

mysqli_close($connect);
?>