<?php
require '../connect.php';

$campid = isset($_POST['campid']) ? $_POST['campid'] : 0;

$sql = "SELECT name FROM camps WHERE id='$campid'";
if($result = mysqli_query($connect, $sql)) {
    if(mysqli_num_rows($result) > 0) {
        foreach($result as $row) {
            $name = $row['name'];
        }
    }
}
$folderName = str_replace(' ', '', $name);

if ($_FILES['image']) {
    $uploadDir = 'images/lagerya/' . $folderName . '/';
    $fileName = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $stmt = $connect->prepare("INSERT INTO images (id, source) VALUES (?, ?)");
        $stmt->bind_param("ss", $campid, $targetFile);

        if ($stmt->execute()) {
            echo "Изображение успешно загружено в базу данных";
        } else {
            echo "Ошибка при загрузке в базу данных: " . $connect->error;
        }

        $stmt->close();
    } else {
        echo "Ошибка при загрузке файла на сервер";
    }
}
?>