<?php
    require '../connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $campName = $_POST["campName"];
        
        $sql = "DELETE FROM user_favorite WHERE camp_name = '$campName'";
        $result = $connect->query($sql);

        if ($result) {
            echo '&#x1F49B;';
        }
    }
?>
