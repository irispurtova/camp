<?php
require '../connect.php';

$campid = isset($_POST['campid']) ? $_POST['campid'] : 0;

if ($_FILES['image']) {
    $uploadDir = 'images/categories/';
    $fileName = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {

        $stmt = "UPDATE categories SET img_cat = '$targetFile' WHERE id_cat = $campid";
        
        if (mysqli_query($connect, $stmt)) {    
            echo "Изображение успешно загружено в базу данных";
        } else {
            echo "Ошибка при загрузке файла на сервер: " . mysqli_error($connect);
        }
    } else {
        echo "Ошибка при загрузке файла на сервер!";
    }
} else {
    echo 'ошибка тут!';
}
?>