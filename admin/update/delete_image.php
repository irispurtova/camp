<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require '../../connect.php';

$campid = mysqli_real_escape_string($connect, $_POST["campId"]);
$imgSrc = mysqli_real_escape_string($connect, $_POST["imgSrc"]);

$sql = "DELETE FROM images WHERE id = $campid AND source = '$imgSrc'";

if ($connect->query($sql) === TRUE) {
} else {
}

$connect->close();
?>