<?php
    require '../connect.php';

    $sql = "SELECT camps.*
            FROM camps
            JOIN user_favorite ON camps.name = user_favorite.camp_name;";

    $res = $connect->query($sql);

    if ($res->num_rows > 0) {
        $i = 1;
        while($row = $res->fetch_assoc()) {
            $id = $row['id'];
            $camp_name = $row["name"];
            $country = $row['country'];
            $region = $row['region'];
            $city = $row['city'];
            $logo = $row['logo'];
            ?>
            <div class="camp">
                <?php
                    $fav = "SELECT * FROM user_favorite WHERE camp_name = '$camp_name'";
                    $res_fav = $connect->query($fav);
                    
                    if ($res_fav->num_rows > 0) {
                        $row_fav = $res_fav->fetch_assoc(); ?>
                        <div id="heart" class="heart-icon red-heart" onclick="delFavorite('<?=$camp_name;?>')">&#x2764;&#xFE0F;</div>
                        <?php
                    }
                ?>
                <div class="img-wrap"><img src="admin/<?=$logo;?>">
            </div>
                <div class="text-wrap">
                    <a href="camp.php?id=<?=$id;?>"><?=$camp_name;?></a>
                    <p class="text-place"><?php echo $country . ', ' . $region . ', ' . $city; ?></p>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<h3>Избранных лагерей нет</h3>';
    }
?>