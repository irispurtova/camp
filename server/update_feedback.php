<?php
require '../connect.php';

$comment_id = $_POST['comment_id'];
$action = $_POST['action'];

if ($action == 'upvote') {
    $sql = "UPDATE feedback SET up = up + 1 WHERE id_feedback = $comment_id";
} elseif ($action == 'downvote') {
    $sql = "UPDATE feedback SET down = down + 1 WHERE id_feedback = $comment_id";
}

if ($connect->query($sql) === TRUE) {
    $sql_updated = "SELECT up, down FROM feedback WHERE id_feedback = $comment_id";
    $result_updated = $connect->query($sql_updated);

    if ($result_updated->num_rows > 0) {
        $row = $result_updated->fetch_assoc();
        $updated_up = $row['up'];
        $updated_down = $row['down'];

        if ($action == 'upvote') {
            echo $updated_up;
        } else if ($action == 'downvote') {
            echo $updated_down;
        }
    } else {
        echo "No data found";
    }
} else {
    echo "Error updating record: " . $connect->error;
}
?>
