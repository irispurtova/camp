<?php require '../connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Все лагеря</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/feedback_admin.css">
</head>

<body>
    <div class="head">
        <div class="admin-header">
            <div class="logo"><img src="../images/logo-white.jpeg" alt="logo" width="49px"></div>
            <div class="welcome">
                Добро пожаловать, Администратор
            </div>
            <div class="bye">
                <a href="../auth/unlog.php">Выйти</a>
            </div>
        </div>
    </div>

    <div class="table-camp">
        <div class="container">
            <div class="bread-crumbs">
                <a href="main.php">Администратор. Главная </a> > Отзывы
            </div>
            <h1>Все отзывы</h1>

            <?php
                if (isset($_GET['del'])) {
                    $pr_del = $_GET['del'];

                    $query = "DELETE FROM feedback WHERE id_feedback = $pr_del";
                    mysqli_query($connect, $query) or die(mysqli_error($connect));
                }
            ?>

            <div class="full">
                <div class="filter-feedback">
                    <form action="" method="post" id="search_fb">
                        <label for="name_camp">Выберите лагерь</label> <br>
                        <select name="name_camp" id="select_camp" onchange="sendFilterRequest(event)" style="cursor: pointer">
                            <option value=""></option>
                            <?php
                                $camps = "SELECT name FROM camps";
                                $res = $connect->query($camps);

                                if ($res->num_rows > 0) {
                                    while($row = $res->fetch_assoc()) {
                                        $name_camp = $row['name']; ?>
                                        
                                        <option value="<?=$name_camp;?>" style="cursor: pointer"><?=$name_camp;?></option>

                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </form>
                    <div class="button" id="filterButton" onclick="resetForm()" style="cursor: pointer; padding-top: 10px">Показать все</div>
                </div>

                <ul class="feedback" id="filteredResults"></ul>                    
            </div>

            <script>
                function sendFilterRequest(event) {
                    event.preventDefault();

                    var select_camp = document.getElementById("select_camp").value;

                    console.log(select_camp);
                    
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("filteredResults").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("POST", "print_feedbacks.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("select_camp=" + encodeURIComponent(select_camp)); 
                }

                function resetForm() {
                    document.getElementById('search_fb').reset();
                    sendFilterRequest(event); 
                }

                document.addEventListener('DOMContentLoaded', function () {
                    sendFilterRequest(event);
                });
            </script>
        </div>
    </div>
</body>

</html>