<?php
    require '../connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $campName = $_POST["campName"];
        
        $sql = "INSERT INTO user_favorite (user_name, camp_name) VALUES ('user', '$campName')";
        $result = $connect->query($sql);

        if ($result) {
            echo '&#x2764;&#xFE0F;';
        }
    }
?>
