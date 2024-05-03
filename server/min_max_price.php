<?php
require '../connect.php';

$sql = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM price";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $min_price = $row["min_price"];
    $max_price = $row["max_price"];
    echo json_encode(array("min" => $min_price, "max" => $max_price));
} else {
    echo json_encode(array("error" => "No results found"));
}

$connect->close();
?>
