<div class="cards">
    <?php

    require '../connect.php';
    session_start();

    $sortDirection = isset($_POST['sortDirection']) ? intval($_POST['sortDirection']) : 0;
    $evSortDirection = isset($_POST['evSortDirection']) ? intval($_POST['evSortDirection']) : 0;
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $region = isset($_POST['region']) ? $_POST['region'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $theme = isset($_POST['theme']) ? $_POST['theme'] : '';
    $season = isset($_POST['season']) ? $_POST['season'] : '';
    $ageString = isset($_POST['age']) ? $_POST['age'] : '';
    $minPrice = isset($_POST['minPrice']) ? intval($_POST['minPrice']) : 0;
    $maxPrice = isset($_POST['maxPrice']) ? intval($_POST['maxPrice']) : PHP_INT_MAX;
    $userName = 'user';

    $sql = "SELECT camps.*, 
            (SELECT ROUND(AVG(feedback.evaluation), 1) 
            FROM feedback 
            WHERE camps.name = feedback.name) AS avg_evaluation, 
            (SELECT price 
            FROM price 
            WHERE camps.name = price.name
            ORDER BY id 
            LIMIT 1) AS first_price 
            FROM camps ";

    if (!empty($season) && $season != 'undefined' && $season != 'Не выбрано') {
        $sql .= "WHERE EXISTS (SELECT 1 
                FROM price 
                WHERE camps.name = price.name 
                AND season = '$season')";
    }

    $whereClause = [];

    if (!empty($country) && $country != 'undefined' && $country != 'Не выбрано') {
        $whereClause[] = "country = '$country'";
    }

    if (!empty($region) && $region != 'undefined' && $region != 'Не выбрано') {
        $whereClause[] = "region = '$region'";
    }

    if (!empty($city) && $city != 'undefined' && $city != 'Не выбрано') {
        $whereClause[] = "city = '$city'";
    }

    if (!empty($theme) && $theme != 'undefined' && $theme != 'Не выбрано') {
        $whereClause[] = "category LIKE '%$theme%'";
    }

    if ($minPrice!=0 && $maxPrice!=0) {
        $whereClause[] = "((SELECT price FROM price WHERE camps.name = price.name ORDER BY id LIMIT 1) BETWEEN $minPrice AND $maxPrice)";
    }    

    $age = 0;

    if (preg_match('/(\d+)\s+(лет|года)/', $ageString, $matches)) {
        $age = intval($matches[1]);
    }
    
    if ($age >= 3 && $age <= 18) {
        $whereClause[] = "($age >= CAST(SUBSTRING_INDEX(age_from, ' ', -3) AS UNSIGNED) AND $age <= CAST(SUBSTRING_INDEX(age_to, ' ', -1) AS UNSIGNED))";
    }

    if (!empty($whereClause)) {
        $sql .= (empty($season) || $season == 'undefined' || $season == 'Не выбрано') ? " WHERE " : " AND ";
        $sql .= implode(" AND ", $whereClause);
    }

    if ($evSortDirection == 1) {
        $sql .= " ORDER BY avg_evaluation ASC";
    } elseif ($evSortDirection == 2) {
        $sql .= " ORDER BY avg_evaluation DESC";
    } elseif ($sortDirection == 1) {
        $sql .= " ORDER BY first_price ASC";
    } elseif ($sortDirection == 2) {
        $sql .= " ORDER BY first_price DESC";
    }

    $result = $connect->query($sql);    

    if (!$result) {
        echo "Ошибка выполнения запроса: " . $connect->error;
    } else {
        if ($result->num_rows > 0) {
        } else {
            echo "Нет лагерей по запросу";
        }
    }       

    if ($result->num_rows > 0) {
        $i = 1;
        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row["name"];
            $logo = $row["logo"];
            $country = $row["country"];
            $region = $row["region"];
            $city = $row["city"];
            $category = $row["category"];
            $age_from = $row["age_from"];
            $age_to = $row['age_to'];
            $desc_card = $row["desc_card"]; ?>

            
            <div class="card-camp">
                <div class="middle-card-camp">
                    <div class="photo"
                        style="width: 185px; height: 290px; background: url('admin/<?=$logo;?>'); background-repeat: no-repeat; background-position: center; background-size: cover;">

                        <?php
                        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') {
                            $fav = "SELECT * FROM user_favorite WHERE camp_name = '$name'";
                            $res_fav = $connect->query($fav);
                            
                            if ($res_fav->num_rows > 0) {
                                $row_fav = $res_fav->fetch_assoc(); ?>
                                <div id="heart" class="heart-icon red-heart" onclick="delFavorite('<?=$name;?>')">&#x2764;&#xFE0F;</div>
                                <?php
                            } else { ?>
                                <div id="heart" class="heart-icon" onclick="addFavorite('<?=$name;?>')">&#x1F49B;</div>
                            <?php
                            }
                        }
                        ?>                        

                    </span>
                    </div>
                    <div class="description">
                        <div class="head">
                            <span class="title">
                                <a href="camp.php?id=<?=$id;?>" style="color: black;">Детский лагерь <?=$name;?></a></span>
                                <?php
                                    $sql1 = "SELECT COUNT(*) AS row_count FROM feedback WHERE name='$name'";
                                    $res1 = $connect->query($sql1);

                                        if ($res1->num_rows > 0) {
                                            $innerRow = $res1->fetch_assoc();
                                            if ($innerRow['row_count'] == 1) { ?>
                                                <span class="feedback" name="sub-to-fb"><a href="feedback.php?name=<?=$name;?>"><?=$innerRow['row_count'];?> отзыв </a></span> <?php
                                            } else if (($innerRow['row_count'] == 2)||($innerRow['row_count'] == 3)||($innerRow['row_count'] == 4)) { ?>
                                                <span class="feedback" name="sub-to-fb"><a href="feedback.php?name=<?=$name;?>"><?=$innerRow['row_count'];?> отзыва</a></span> <?php
                                            } else {?>
                                                <span class="feedback" name="sub-to-fb"><a href="feedback.php?name=<?=$name;?>"><?=$innerRow['row_count'];?> отзывов</a></span> <?php
                                            }
                                        } ?>
                            
                            <div class="ev">
                                <?php
                                    $ev="SELECT ROUND(AVG(evaluation), 1) AS rounded_average_evaluation FROM feedback WHERE name = '$name'";
                                    $res_ev = $connect->query($ev);

                                    if ($res1->num_rows > 0) {
                                        $ev_in = $res_ev->fetch_assoc();
                                        echo $ev_in['rounded_average_evaluation'];
                                        if ($ev_in['rounded_average_evaluation'] == null) {
                                            echo '0.0';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="place"><?php echo $country . ', ' . $region . ', ' . $city;?></div>
                        <?php
                            $sql2 = "SELECT category FROM camps WHERE name='$name'";
                            $result2 = $connect->query($sql2);
                            
                            if ($result2->num_rows > 0) {
                                echo '<div class="cat">';
                                while($row = $result2->fetch_assoc()) {
                                    $categories = explode(' ', $row['category']);
                                    foreach ($categories as $category) {
                                        echo '<div class="cat-block">' . $category . '</div>';
                                    }
                                }
                                echo '</div>';
                                echo '<div class="cat" style="padding-top: 0px">';
                                echo '<div class="cat-block">от ' . $age_from . ' до ' . $age_to . ' лет</div>';
                                echo '</div>';
                            }
                        ?>
                        <div class="desc"><?=$desc_card;?></div>
                    </div>
                </div>

                <div class="bottom-card-camp">

                    <div class="styled-select" id="styled-select<?=$i;?>">
                        <div class="title">Сезоны лагеря:</div>
                        <?php
                            $initialSeason = "";
                            $initialPrice = "";

                            $sql3="SELECT season, price FROM price WHERE id_camp='$id'";
                            $result3 = $connect->query($sql3);

                            if ($result3->num_rows > 0) {
                                $row = $result3->fetch_assoc();
                                $initialSeason = $row['season'];
                                $initialPrice = $row['price'];
                            }
                        ?>
                        <div class="selected-option"><?php echo $initialSeason !== "" ? $initialSeason.' - '.number_format($initialPrice, 0, '.', ' ').' ₽' : ''; ?></div>
                        <div class="options-container" id="ooo<?=$i;?>">
                            <?php
                                $sql4="SELECT season, price FROM price WHERE name='$name'";
                                $result4 = $connect->query($sql4);

                                if ($result4->num_rows > 0) {
                                    while($row = $result4->fetch_assoc()) { 
                                        $season = $row['season'];
                                        $price = $row['price'];?>

                                        <div data-value="value1"><?php echo $season.' - '.number_format($price, 0, '.', ' ').' ₽'; ?></div> <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>

                    <div id="price" class="price<?=$i;?>">
                        <div class="top"></div>
                    </div>

                    <a href="camp.php?id=<?=$id;?>">
                        <div class="learn-more">УЗНАТЬ БОЛЬШЕ</div>
                    </a>

                    <a class="link-question">
                        <div class="booking" id="reserveButton" onclick="openBookingModal(<?php echo $i; ?>, '<?php echo $name; ?>')">
                            БРОНИРОВАТЬ
                        </div>
                    </a>

                </div>
            </div> <?php 

            $i++;
        }
    }
    ?>
</div>