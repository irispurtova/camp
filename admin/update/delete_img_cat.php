<?php

require '../../connect.php';

$campid = mysqli_real_escape_string($connect, $_POST["campId"]);
$imgSrc = mysqli_real_escape_string($connect, $_POST["imgSrc"]);

$sql = "UPDATE categories SET img_cat = null WHERE id_cat = $campid AND img_cat = '$imgSrc'";

if ($connect->query($sql) === TRUE) {
    //echo "Image deleted successfully";
} else {
    //echo "Error deleting image: " . $connect->error;
}

// Закрытие соединения с базой данных
$connect->close();
?>