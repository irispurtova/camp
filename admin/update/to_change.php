<?php
    require '../../connect.php';

    $change1 = isset($_POST['change1']) ? $_POST['change1'] : '';
    $change2 = isset($_POST['change2']) ? $_POST['change2'] : '';

    $id = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;
    
    $sql = "UPDATE categories SET popular = ";
    if ($change2 == 'yes') {
        $sql .= "'yes' ";
    } else if ($change1 == 'no') {
        $sql .= "'no' ";
    }
    $sql .= "WHERE id_cat = $id";

    echo $sql;

    $result = mysqli_query($connect, $sql);

    if ($result) {
        echo ' успех';
    } else {
        echo ' ошибка';
    }
?>