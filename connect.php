<?php
$connect = mysqli_connect(
    'localhost',
    'root',
    '',
    'camp');

if (!$connect) {
    echo 'Error!';
}
?>