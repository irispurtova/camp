<?php 
require 'connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лучшие детские лагеря</title>

    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
    <?php require 'header.php'; ?>
    <div class="banner">
        <div class="container">
            <div class="banner-info">
                <h1>Детские лагеря на 2024 год</h1>
                <p>
                    <span class="yellow">Более 5000 вариантов</span>
                    <span class="white">программ и направлений детского отдыха</span>
                </p>
                <div class="search">

                    <form action="lagerya.php" method="POST">
                        <div class="dropdowns">
                            <select class="dropdowns_element" id="select_county" name="country">
                                <option value="">Страна</option>
                                <?php
                                    $sql = "SELECT DISTINCT country FROM camps";
                                    $result = $connect->query($sql);
                                    $country = "";

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $country = $row["country"]; ?>
                                            <option value="<?= $country; ?>"><?= $country; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select><!--
                        --><select class="dropdowns_element" id="select_region" name="region">
                                <option value="">Регион</option>
                                <?php
                                    $sql = "SELECT DISTINCT region FROM camps";
                                    $result = $connect->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $region = $row["region"]; ?>
                                            <option value="<?= $region; ?>"><?= $region; ?></a><?php
                                        }
                                    }
                                ?>
                            </select><!--
                        --><select class="dropdowns_element" id="select_type" name="category">
                                <option value="">Тип лагеря</option>
                                <?php
                                    $sql = "SELECT * FROM categories";
                                    $result = $connect->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $category = $row["category"]; ?>
                                            <option value="<?= $category; ?>"><?= $category; ?></a><?php
                                        }
                                    }
                                ?>
                            </select><!--
                        --><select class="dropdowns_element" id="select_sezon" name="season">
                                <option value="">Сезон</option>
                                <?php
                                    $sql = "SELECT * FROM season";
                                    $result = $connect->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $season = $row["season"]; ?>
                                            <option value="<?= $season; ?>"><?= $season; ?></a><?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <input type="submit" class="found" value="НАЙТИ">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="categories">
        <div class="container">
            <div class="text-cat">
                <h2>Популярные категории</h2>
                <?php
                    $count = "SELECT COUNT(*) AS TotalRows FROM categories";
                    $res = $connect->query($count);

                    if ($res->num_rows > 0) {
                        $row = $res->fetch_assoc();?>
                        <p>Показано <strong>6 категорий</strong> из <strong><?=$row['TotalRows'];?></strong></p> <?php                        
                    } 

                ?>
                
            </div>

            <div class="categories-list">
                <ul class="categories-list-popular">
                <?php
                    $sql = "SELECT * FROM `categories` WHERE `img_cat` != '' AND `popular`='yes' LIMIT 3";
                    $result = $connect->query($sql);

                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            $imagePath = $row["img_cat"];
                            $category = $row["category"];

                            if ($i==3) {
                            ?>
                                <li class="hide"
                                style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?=$imagePath;?>'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                                <form action="lagerya.php" method="POST" style="height: 100%" id="form1">
                                    <div class="block">
                                        <div class="text">
                                            <div class="submit1" style="cursor:pointer"><?=$category;?></div>
                                            <input type="hidden" value="<?=$category;?>" name="category_camp">
                                            <?php
                                                $sql="SELECT COUNT(*) AS TotalRows FROM camps WHERE category LIKE '%$category%';";
                                                $res = $connect->query($sql);

                                                if ($res->num_rows > 0) {
                                                    $row = $res->fetch_assoc();
                                                    if ($row['TotalRows'] == 1) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерь</p><?php
                                                    } else if ((2 <= $row['TotalRows']) && ($row['TotalRows'] <= 4)) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагеря</p><?php
                                                    } else if ($row['TotalRows'] > 4) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерей</p><?php
                                                    }
                                                }
                                            ?>                                            
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    const form1 = document.getElementById('form1');
                                    document.querySelector('.submit1').addEventListener('click', function(){
                                        form1.submit();
                                    })
                                </script>
                            </li> <?php
                            } else if ($i==1) {
                                ?>
                                <li class="small"
                                style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?=$imagePath;?>'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                                <form action="lagerya.php" method="POST" style="height: 100%" id="form2">
                                    <div class="block">
                                        <div class="text">
                                            <div class="submit2" style="cursor:pointer"><?=$category;?></div>
                                            <input type="hidden" value="<?=$category;?>" name="category_camp">
                                            <?php
                                                $sql="SELECT COUNT(*) AS TotalRows FROM camps WHERE category LIKE '%$category%';";
                                                $res = $connect->query($sql);

                                                if ($res->num_rows > 0) {
                                                    $row = $res->fetch_assoc();
                                                    if ($row['TotalRows'] == 1) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерь</p><?php
                                                    } else if ((2 <= $row['TotalRows']) && ($row['TotalRows'] <= 4)) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагеря</p><?php
                                                    } else if ($row['TotalRows'] > 4) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерей</p><?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    const form2 = document.getElementById('form2');
                                    document.querySelector('.submit2').addEventListener('click', function(){
                                        form2.submit();
                                    })
                                </script>
                                <?php
                            } else if ($i==2) {
                                ?>
                                <li class="small"
                                style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?=$imagePath;?>'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                                <form action="lagerya.php" method="POST" style="height: 100%" id="form3">
                                    <div class="block">
                                        <div class="text">
                                            <div class="submit3" style="cursor:pointer"><?=$category;?></div>
                                            <input type="hidden" value="<?=$category;?>" name="category_camp">
                                            <?php
                                                $sql="SELECT COUNT(*) AS TotalRows FROM camps WHERE category LIKE '%$category%';";
                                                $res = $connect->query($sql);

                                                if ($res->num_rows > 0) {
                                                    $row = $res->fetch_assoc();
                                                    if ($row['TotalRows'] == 1) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерь</p><?php
                                                    } else if ((2 <= $row['TotalRows']) && ($row['TotalRows'] <= 4)) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагеря</p><?php
                                                    } else if ($row['TotalRows'] > 4) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерей</p><?php
                                                    }
                                                } else {?>
                                                    <p class="quantity">0 лагерей</p><?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    const form3 = document.getElementById('form3');
                                    document.querySelector('.submit3').addEventListener('click', function(){
                                        form3.submit();
                                    })
                                </script>
                                <?php
                            }                             
                            $i++;
                        }
                    }
                ?>
                </ul>

                <ul class="categories-list-popular">
                <?php
                    $sql = "SELECT * FROM `categories` WHERE `img_cat` != '' AND `popular`='yes' LIMIT 3, 3";
                    $result = $connect->query($sql);

                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            $imagePath = $row["img_cat"];
                            $category = $row["category"];

                            if ($i==1) {
                            ?>
                                <li class="hide"
                                style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?=$imagePath;?>'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                                <form action="lagerya.php" method="POST" style="height: 100%" id="form4">
                                    <div class="block">
                                        <div class="text">
                                            <div class="submit4" style="cursor:pointer"><?=$category;?></div>
                                            <input type="hidden" value="<?=$category;?>" name="category_camp">
                                            <?php
                                                $sql="SELECT COUNT(*) AS TotalRows FROM camps WHERE category LIKE '%$category%';";
                                                $res = $connect->query($sql);

                                                if ($res->num_rows > 0) {
                                                    $row = $res->fetch_assoc();
                                                    if ($row['TotalRows'] == 1) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерь</p><?php
                                                    } else if ((2 <= $row['TotalRows']) && ($row['TotalRows'] <= 4)) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагеря</p><?php
                                                    } else if ($row['TotalRows'] > 4) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерей</p><?php
                                                    }
                                                } else {?>
                                                    <p class="quantity">0 лагерей</p><?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    const form4 = document.getElementById('form4');
                                    document.querySelector('.submit4').addEventListener('click', function(){
                                        form4.submit();
                                    })
                                </script>
                            </li> <?php
                            } else if ($i==2){
                                ?>
                                <li class="small"
                                style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?=$imagePath;?>'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                                <form action="lagerya.php" method="POST" style="height: 100%" id="form5">
                                    <div class="block">
                                        <div class="text">
                                            <div class="submit5" style="cursor:pointer"><?=$category;?></div>
                                            <input type="hidden" value="<?=$category;?>" name="category_camp">
                                            <?php
                                                $sql="SELECT COUNT(*) AS TotalRows FROM camps WHERE category LIKE '%$category%';";
                                                $res = $connect->query($sql);

                                                if ($res->num_rows > 0) {
                                                    $row = $res->fetch_assoc();
                                                    if ($row['TotalRows'] == 1) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерь</p><?php
                                                    } else if ((2 <= $row['TotalRows']) && ($row['TotalRows'] <= 4)) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагеря</p><?php
                                                    } else if ($row['TotalRows'] > 4) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерей</p><?php
                                                    }
                                                } else {?>
                                                    <p class="quantity">0 лагерей</p><?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    const form5 = document.getElementById('form5');
                                    document.querySelector('.submit5').addEventListener('click', function(){
                                        form5.submit();
                                    })
                                </script>
                                <?php
                            } else if ($i==3){
                                ?>
                                <li class="small"
                                style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('<?=$imagePath;?>'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                                <form action="lagerya.php" method="POST" style="height: 100%" id="form6">
                                    <div class="block">
                                        <div class="text">
                                            <div class="submit6" style="cursor:pointer"><?=$category;?></div>
                                            <input type="hidden" value="<?=$category;?>" name="category_camp">
                                            <?php
                                                $sql="SELECT COUNT(*) AS TotalRows FROM camps WHERE category LIKE '%$category%';";
                                                $res = $connect->query($sql);

                                                if ($res->num_rows > 0) {
                                                    $row = $res->fetch_assoc();
                                                    if ($row['TotalRows'] == 1) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерь</p><?php
                                                    } else if ((2 <= $row['TotalRows']) && ($row['TotalRows'] <= 4)) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагеря</p><?php
                                                    } else if ($row['TotalRows'] > 4) {?>
                                                        <p class="quantity"><?=$row['TotalRows'];?> лагерей</p><?php
                                                    }
                                                } else {?>
                                                    <p class="quantity">0 лагерей</p><?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                                <script>
                                    const form6 = document.getElementById('form6');
                                    document.querySelector('.submit6').addEventListener('click', function(){
                                        form6.submit();
                                    })
                                </script>
                                <?php
                            }                             
                            $i++;
                        }
                    }
                ?>
                </ul>
            </div>

            <a href="lagerya.php" class="cat_plus">Еще категории <img src="images/arrow-link-style.svg" alt="arr"
                    style="vertical-align: middle;"></a>
        </div>
    </div>

    <div class="description">
        <div class="container">
            <h2>KIDS<span class="yellow" style="font-size: 32px;">IN</span>CAMP.RU помогает найти для Вас <strong>лучший
                    лагерь</strong>, основываясь на самом важном при планировании каникул</h2>
            <div class="info-texts-block">
                <div class="left">
                    <p>Подобрать наиболее подходящий лагерь будет просто, ведь на сайте представлены лагеря,
                        отличающиеся разнообразным детским досугом, хорошими условиями проживания и внимательным
                        отношением к детям.
                    </p>
                    <p style="color: #1950a0;">Сравнивайте цены, изучайте фотоматериалы и программу, и вы сможете
                        организовать такой отдых, от
                        которого ваш ребенок будет в восторге!</p>
                </div>
                <div class="right">
                    <p class="likes">
                        <img src="images/like-icon.svg" alt=""> Только честные отзывы
                    </p>
                    <p class="likes">
                        <img src="images/like-icon.svg" alt=""> Проверяем каждого партнера
                    </p>
                    <p class="likes">
                        <img src="images/like-icon.svg" alt=""> <strong>Без комиссии за бронирование</strong>
                    </p>
                    <p class="likes">
                        <img src="images/like-icon.svg" alt=""> <strong>Без штрафа за отмену или изменение в
                            брони</strong>
                    </p>
                </div>
            </div>
            <div class="info-texts-block">
                <div class="left">
                    <p>Kidsincamp – это более 5000 вариантов программ и направлений детского и моложёного отдыха по
                        всему миру. Сравнивайте цены, изучайте фотоматериалы и программу, и вы сможете организовать
                        такой отдых, от которого ваш ребенок будет в восторге!</p>
                </div>
                <div class="right">
                    <p style="font-size: 14px;">Kidsincamp предлагает родителям подобрать подходящий детский лагерь и
                        забронировать путевку по
                        выгодным ценам. На сайте представлены лагеря с детальным описанием, отличающиеся разнообразным
                        детским досугом, программами, хорошими условиями проживания и внимательным отношением к детям.
                        Отталкиваясь от увлечений и нужд вашего ребенка, вы сможете подыскать наилучшую программу.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="best_place_text">
        <div class="container">
            <h2>
                Детский лагерь — лучшее место для отдыха вашего ребенка? <br>
                <strong>Мы уверенно отвечаем: “<span class="yellow" style="font-size: 32px;">Да!</span>”</strong>
            </h2>
            <div class="info-texts-block" style="color: #1950a0;">
                <div class="left">
                    <p>
                        В современных лагерях дети проводят время не только весело, но и с пользой. Отдых во время
                        каникул с учетом интересов и предпочтений ребят — это реально. Творческих личностей ждут
                        танцевальные,
                    </p>
                </div>
                <div class="right" style="font-size: 14px;">
                    <p>
                        художественные, музыкальные лагеря, а детям с богатым воображением будут рады в ролевых.
                        Спортивные и образовательные, языковые и кулинарные — для каждого ребенка или подростка можно
                        найти отличный вариант!
                    </p>
                </div>
            </div>

            <p style="color: #1950a0; font-size: 32px; padding-bottom: 10px;">Как выбрать детский лагерь?</p>
            <div class="info-texts-block" style="flex-direction: column;">
                <p class="likes">
                    <img src="images/like-icon.svg" alt="">
                    <span>На нашем портале собрана подробная информация о лагерях по
                        всей России и за рубежом. Достаточно воспользоваться фильтром, чтобы найти предпочтительный
                        вариант:
                        нужно выбрать регион, возраст ребенка и тип лагеря.</span>
                </p>
                <p class="likes">
                    <img src="images/like-icon.svg" alt="">
                    <span>Открыв страницу заинтересовавшего вас лагеря, вы сможете
                        узнать о нем всю необходимую информацию: о расположении, условиях проживания и питании,
                        программе,
                        команде. Познакомиться с отзывами детей и родителей, посмотреть фотографии и видео. </span>
                </p>
                <p class="likes">
                    <img src="images/like-icon.svg" alt="">
                    <span>Выбор детского лагеря — это важное решение, и мы готовы
                        помочь вам в этом процессе! Ваши дети получат незабываемые впечатления о ярком увлекательном
                        отдыхе.</span>
                </p>

                <div class="button">
                    <a href="lagerya.php" style="color: white;">Подобрать лагерь</a>
                </div>
            </div>
        </div>
    </div>

    <div class="feedback">
        <div class="container">
            <h1>Отзывы о лагерях</h1>
            <div class="fb-blocks">
                <?php
                    $sql = "SELECT * FROM feedback WHERE LENGTH(text) - LENGTH(REPLACE(text, ' ', '')) + 1 <= 70 ORDER BY RAND() LIMIT 3";
                    $result = $connect->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
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

                            <div class="block">
                                <div class="block-top">
                                    <div class="title-camp"><strong><a href="feedback.php?name=<?=$name;?>"><?=$name;?>.</a></strong></div>
                                    <div class="evaluation"><?=$evaluation;?></div>
                                </div>
                                <div class="text" style="height: 150px; padding-top: 10px"><?=$text;?></div>
                                <div class="block-bottom">
                                    <div class="user"><strong><?=$user;?></strong></div>
                                </div>                    
                            </div> <?php
                        }
                    }
                ?>
            </div>
    
            <a href="feedback.php" style="color: #3a3a3a;">Все отзывы <img src="images/button-arrow.svg" alt="" style="vertical-align: middle;"></a>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="tel">
                <div class="title">Телефон</div>
                <p><a href="#">+7 (495) 230-14-78</a></p>
                <div class="schedule">пн-пн 10:00 - 18:00</div>
            </div>
            <div class="e-mail">
                <div class="title">E-mail</div>
                <p><a href="#">info@kidsincamp.ru</a></p>
            </div>
            <div class="images">
                <div class="rep"><img src="images/orig.png" alt="" width="70%"></div>
                <div class="logoh1"><img src="images/logo1h.png" alt=""></div>
            </div>
        </div>
    </div>
</body>

</html>