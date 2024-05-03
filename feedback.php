<?php require 'connect.php'; session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отзывы</title>

    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/feedback.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
    <?php require 'header.php'; ?>

    <div class="feedback">
        <div class="container">
            <p class="bread-crumbs" style="font-size: 12px;">
                <a href="index.php" style="color: #585858;">Главная > </a> Отзывы о лагерях
            </p>
            <h1>Отзывы о лагерях</h1>
            <?php
                $count = "SELECT COUNT(*) AS TotalRows FROM feedback";
                $res = $connect->query($count);

                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();?>
                    <br><p>Всего отзывов о лагерях: <?=$row['TotalRows'];?></p> <br><?php                        
                } 
            ?>            

            <div class="container-feedback">
                <div class="left">
                    <ul class="reviews-list" id="filteredResults">
                        <?php include 'print_feedback.php'; ?>
                    </ul>                    
                </div>

                <div class="right">
                    <div class="filter-feedback">                        
                            <form method="post" id="search_fb">
                                <label for="searchTerm" style="font-weight: bold">Фильтр по названию:</label>
                                <?php
                                    if (isset($_GET['name'])&&($_GET['name']!='')) {
                                        $val_search = $_GET['name'];
                                    } else {
                                        $val_search = '';
                                    }
                                ?> 
                                <input type="text" id="searchTerm" placeholder="Название лагеря..." oninput="sendFilterRequest(event)" value="<?=$val_search;?>">                                                                 
                            
                                <br>

                                <p style="padding: 10px 0px; font-weight: bold">Фильтр по оценке:</p>
                                <div class="filter-container">
                                    <div class="checkbox-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="5" id="check_value5" onchange="sendFilterRequest(event)">
                                                <span class="custom-checkbox"></span> Отлично (Оценка 5)
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="4" id="check_value4" onchange="sendFilterRequest(event)">
                                                <span class="custom-checkbox"></span> Хорошо (Оценка 4)
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="3" id="check_value3" onchange="sendFilterRequest(event)">
                                                <span class="custom-checkbox"></span> Средне (Оценка 3)
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="2" id="check_value2" onchange="sendFilterRequest(event)">
                                                <span class="custom-checkbox"></span> Плохо (Оценка от 1 до 2)
                                            </label>
                                        </div>
                                    </div>

                                    <div class="button" id="filterButton" onclick="resetForm()">СБРОСИТЬ ФИЛЬТР</div>
                            </form>

                            <script>
                                function sendFilterRequest(event) {
                                    event.preventDefault();

                                    var search_name = document.getElementById('searchTerm').value;
                                    search_name.toUpperCase();

                                    if (document.getElementById('check_value5').checked) {
                                        var check_value1 = document.getElementById('check_value5').value;
                                    } else {var check_value1 = '';}
                                    if (document.getElementById('check_value4').checked) {
                                        var check_value2 = document.getElementById('check_value4').value;
                                    } else {var check_value2 = '';}
                                    if (document.getElementById('check_value3').checked) {
                                        var check_value3 = document.getElementById('check_value3').value;
                                    } else {var check_value3 = '';}
                                    if (document.getElementById('check_value2').checked) {
                                        var check_value4 = document.getElementById('check_value2').value;
                                    } else {var check_value4 = '';}
                                    
                                    var xhttp = new XMLHttpRequest();
                                    xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            document.getElementById("filteredResults").innerHTML = this.responseText;
                                        }
                                    };
                                    xhttp.open("POST", "print_feedback.php", true);
                                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    xhttp.send("check_value1=" + encodeURIComponent(check_value1) + 
                                            "&check_value2=" + encodeURIComponent(check_value2) +
                                            "&check_value3=" + encodeURIComponent(check_value3) +
                                            "&check_value4=" + encodeURIComponent(check_value4) +
                                            "&search_name=" + encodeURIComponent(search_name)); 
                                }

                                function resetForm() {
                                    document.getElementById('search_fb').reset();
                                    document.getElementById('searchTerm').value = '';
                                    sendFilterRequest(event); 
                                }

                                document.addEventListener('DOMContentLoaded', function () {
                                    sendFilterRequest(event); 
                                });
                                
                                function thumbUp(commentId) {
                                    var xhttp = new XMLHttpRequest();
                                    xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            
                                            document.getElementById("upvotes_" + commentId).innerHTML = this.responseText;
                                        }
                                    };
                                    xhttp.open("POST", "server/update_feedback.php", true);
                                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    xhttp.send("comment_id=" + encodeURIComponent(commentId) + "&action=upvote");
                                }

                                function thumbDown(commentId) {
                                    var xhttp = new XMLHttpRequest();
                                    xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            document.getElementById("downvotes_" + commentId).innerHTML = this.responseText;
                                        }
                                    };
                                    xhttp.open("POST", "server/update_feedback.php", true);
                                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    xhttp.send("comment_id=" + encodeURIComponent(commentId) + "&action=downvote");
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
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