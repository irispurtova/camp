<?php require 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Избранное</title>

    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/favorite.css">
</head>

<body>
    <?php 
        require 'header.php'; 
        require 'connect.php';
    ?>

    <div class="favorite">
        <div class="container">
            <div class="bread-crumbs">
                <p style="font-size: 12px;">
                    <a href="index.php" style="color: #585858;">Главная > </a>Избранное
                </p>
            </div>

            <h1>Избранные лагеря</h1>

            <div class="camps">
                <div id="campsContainer"></div>                
            </div>
        </div>
    </div>

    <script>
        function sendAjaxRequest() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("campsContainer").innerHTML = this.responseText;
                }
            };
            xhttp.open("POST", "server/print_fav_camp.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(); 
        }

        function delFavorite(campName) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('heart').innerHTML = xhttp.response;
                } 
            };
            xhttp.open("POST", "server/del_favorite.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("campName=" + encodeURIComponent(campName));

            //sendAjaxRequest();
            location.reload();
        }

        document.addEventListener('DOMContentLoaded', function () {
            sendAjaxRequest();
        });
    </script>

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