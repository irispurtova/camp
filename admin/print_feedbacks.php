<?php 
    require '../connect.php';

    $select_camp = isset($_POST['select_camp']) ? $_POST['select_camp'] : '';

    $sql = "SELECT * FROM feedback";

    if ($select_camp != '') {
        $sql .= " WHERE name = '$select_camp'";
    }

    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row['id_feedback'];
            $user = $row['user'];
            $name = $row['name'];
            $text = $row['text'];
            $evaluation = $row['evaluation'];

            if ($evaluation==5) {
                $ev_text='Отлично';
            }
            if ($evaluation==4) {
                $ev_text='Хорошо';
            }
            if ($evaluation==3) {
                $ev_text='Средне';
            }
            if ($evaluation==2) {
                $ev_text='Плохо';
            } ?>

            <li class="comment">
                <div class="user-camp">
                    <?php            
                        $sql_icon = "SELECT icon FROM icons ORDER BY RAND() LIMIT 1";
                        $result_icon = $connect->query($sql_icon);

                        if ($result_icon->num_rows > 0) {
                            while ($row = $result_icon->fetch_assoc()) {
                                $imagePath = $row["icon"];
                            }
                        }            
                    ?>
                    <div class="ph" style="margin: 0px;"><img src="../<?=$imagePath;?>"
                            width="40px" alt=""></div>
                    <div class="name"><?=$user;?></div>
                    <div class="camp">отзыв о лагере <?=$name;?></div>
                    <div class="del"><a href="?del=<?=$id?>" onclick="return confirm('Вы уверены?');">Удалить отзыв</a></div>
                </div>
                <div class="text"><?=$text;?>
                </div>
                <div class="rep">
                    <div class="stars"><strong>Общаяя оценка: </strong><img
                            src="../images/feedback/stars/s<?=$evaluation;?>.svg" alt="" style="vertical-align: middle;"></div>
                    <div class="evaluation"><strong><?=$ev_text;?>: <span
                                style="color: #1950a0;"><?=$evaluation;?></span></strong></div>
                </div>
            </li>
            
            <?php
        }
    } else {
        'ничего не вышло!';
    }
?>

