<?php 
    require 'connect.php';

    $check_value1 = isset($_POST['check_value1']) ? $_POST['check_value1'] : '';
    $check_value2 = isset($_POST['check_value2']) ? $_POST['check_value2'] : '';
    $check_value3 = isset($_POST['check_value3']) ? $_POST['check_value3'] : '';
    $check_value4 = isset($_POST['check_value4']) ? $_POST['check_value4'] : '';
    $search_name = isset($_POST['search_name']) ? $_POST['search_name'] : '';

    $sql = "SELECT * FROM feedback";

    if ($check_value1 != '') {
        $sql .= " WHERE evaluation = '$check_value1'";
        if (($check_value2 != '')||($check_value3 != '')||($check_value4 != '')) {
            if ($check_value2 != '') {
                $sql .= " OR evaluation = '$check_value2'";
            }
            if ($check_value3 != '') {
                $sql .= " OR evaluation = '$check_value3'";
            }
            if ($check_value4 != '') {
                $sql .= " OR evaluation = '$check_value4'";
            }
        }

        if ($search_name != '') {
            $sql .= " AND name LIKE '%$search_name%'"; 
        } 
    } else if ($check_value2 != '') {
        $sql .= " WHERE evaluation = '$check_value2'";
        if (($check_value3 != '')||($check_value4 != '')) {
            if ($check_value3 != '') {
                $sql .= " OR evaluation = '$check_value3'";
            }
            if ($check_value4 != '') {
                $sql .= " OR evaluation = '$check_value4'";
            }
        }

        if ($search_name != '') {
            $sql .= " AND name LIKE '%$search_name%'"; 
        } 
    } else if ($check_value3 != '') {
        $sql .= " WHERE evaluation = '$check_value3'";
        if ($check_value4 != '') {
            if ($check_value4 != '') {
                $sql .= " OR evaluation = '$check_value4'";
            }
        }

        if ($search_name != '') {
            $sql .= " AND name LIKE '%$search_name%'"; 
        } 
    } else if ($check_value4 != '') {
        $sql .= " WHERE evaluation = '$check_value4'";

        if ($search_name != '') {
            $sql .= " AND name LIKE '%$search_name%'"; 
        } 
    } else if ($search_name != '') {
        $sql .= " WHERE name LIKE '%$search_name%'";
    }       

    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row['id_feedback'];
            $user = $row['user'];
            $name = $row['name'];
            $text = $row['text'];
            $evaluation = $row['evaluation'];
            $up = $row['up'];
            $down = $row['down'];

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
            } 
            if ($evaluation==1) {
                $ev_text='Очень плохо';
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
                    <div class="ph" style="margin: 0px;"><img src="<?=$imagePath;?>"
                            width="40px" alt=""></div>
                    <div class="name"><?=$user;?></div>
                    <div class="camp">отзыв о лагере <?=$name;?></div>
                </div>
                <div class="text"><?=$text;?></div>
                <div class="rep">
                    <div class="stars"><strong>Общаяя оценка: </strong><img
                            src="images/feedback/stars/s<?=$evaluation;?>.svg" alt="" style="vertical-align: middle;"></div>
                    <div class="evaluation"><strong><?=$ev_text;?>: <span
                                style="color: #1950a0;"><?=$evaluation;?></span></strong></div>
                </div>
                <div class="fingers" style="padding: 5px">
                    <span class="up" style="cursor: pointer" onclick="thumbUp(<?=$id;?>)">
                        <img src="images/finger-up.svg"> 
                        <span id="upvotes_<?=$id;?>"><?=$up;?></span> &nbsp; 
                    </span>
                    <span class="down" style="cursor: pointer" onclick="thumbDown(<?=$id;?>)">
                        <img src="images/finger-down.svg"> 
                        <span id="downvotes_<?=$id;?>"><?=$down;?></span> &nbsp; 
                    </span>
                </div>
            </li>
            
            <?php
        }
    } else {
        'ничего не вышло!';
    }
?>

