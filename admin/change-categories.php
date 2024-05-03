<?php require '../connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Редактирование категорий</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/change-categories.css">
    <link rel="stylesheet" type="text/css" href="css/booking.css">
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

    <?php
        if (isset($_GET['del'])) {
            $id_cat = $_GET['del'];
        
            $query_get_category = "SELECT category FROM categories WHERE id_cat = '$id_cat'";
            $result_get_category = mysqli_query($connect, $query_get_category);
            $row_get_category = mysqli_fetch_assoc($result_get_category);
            $category_to_delete = $row_get_category['category'];
        
            $query_update_camps = "SELECT * FROM camps WHERE category LIKE '%$category_to_delete%'";
            $result_update_camps = mysqli_query($connect, $query_update_camps);
        
            while ($row = mysqli_fetch_assoc($result_update_camps)) {
                $camp_id = $row['id'];
                $camp_category = $row['category'];
                $updated_category = str_replace($category_to_delete, '', $camp_category);
                $updated_category = preg_replace('/\s+/', ' ', $updated_category);
                $query_update_category = "UPDATE camps SET category = '$updated_category' WHERE id = '$camp_id'";
                mysqli_query($connect, $query_update_category);
            }
        
            $query_delete_category = "DELETE FROM categories WHERE id_cat = '$id_cat'";
            mysqli_query($connect, $query_delete_category) or die(mysqli_error($connect));
        }
    ?>

    <div class="table-camp">
        <div class="container">
            <div class="bread-crumbs">
                <a href="main.php">Администратор. Главная </a> > Изменение списка категорий лагерей
            </div>

            <?php
                $count = "SELECT COUNT(*) AS TotalRows FROM categories WHERE popular = 'yes'";
                $res = $connect->query($count);

                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                } 
            ?>

            <h1 style="margin-bottom: 10px;">Категории</h1>
            <h3>Обратите внимание, что популярных категорий может быть только 6 
                <span class="count_popular" style="font-weight: 100">Количество выбранных популярных категорий: 
                    <?php
                        if ($row['TotalRows'] != '6') {
                            echo '<span class="color-pop" style="color: red">' . $row["TotalRows"] . '</span>';
                        } else {
                            echo '<span class="color-pop" style="color: green">' . $row["TotalRows"] . '</span>';
                        }
                    ?>                    
                </span>
            </h3> <br>
            
            <form action="search.php" method="post">
                <label for="searchTerm">Поиск по названию:</label>
                <input type="text" id="searchTerm" oninput="search()" required style='font-size: 18px;'>
                <button type="submit" style="display: none">Поиск</button>
            </form>

            <div class="add-category"><a href="add-category.php" style="color: white">Добавить категорию</a></div>

            <div class="show-all">
                <a href="">Показать все</a>
            </div>

            <div class="table">
                <table class="table" id="searchResults" style="width: 100%"></table>
            </div>

            <table id="dataTable" style="display: none;" class="right">
                <thead>
                    <tr>
                        <td>№</td>
                        <td>Категория</td>
                        <td>Изображение</td>
                        <td>Популярность</td>
                        <td>Действие</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $table_sql = "SELECT * FROM categories";
                        $res_table = mysqli_query($connect, $table_sql);
                        $count=0;

                        if ($res_table) {
                            $count=1;
    
                            while($row = mysqli_fetch_assoc($res_table)) {  
                                $id_cat = $row['id_cat']; 
                                $category = $row['category'];
                                $img_cat = $row['img_cat'];
                                $popular = $row['popular']; ?>
                                
                                <tr>
                                    <td><?=$count;?></td>
                                    <td><?=$category;?></td>
                                    <td><img src="../<?=$img_cat;?>" style="width: 130px"></td>
                                    <td id="Results">                                        
                                        <?php 
                                        if ($popular=='yes') { ?>
                                            <span class="pop" style="color: green"> <?=$popular;?> </span> / 
                                            <span class="unpop" id="changes1" onclick="change_cat_to_yes(event, <?=$id_cat;?>)" style="cursor: pointer">no</span> <?php
                                        } else if ($popular=='no') { ?>
                                            <span class="pop" id="changes2" onclick="change_cat_to_no(event, <?=$id_cat;?>)" style="cursor: pointer">yes</span> / 
                                            <span class="unpop" style="color: red"> <?=$popular;?> </span> <?php
                                        }?>
                                        </td>
                                    <td><a href="?del=<?=$id_cat?>" onclick="return confirm('Вы уверены?');">Удалить</a> / <a href="upd_cat.php?id=<?=$id_cat?>">Изменить</a></td>
                                </tr> <?php
                                $count++;
                            }                             
                        }
                    ?>

                    <script>
                        function change_cat_to_yes(event, id_cat) {                            
                            var change1 = document.getElementById('changes1').textContent;                            
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    location.reload();
                                }
                            };
                            xhttp.open("POST", "update/to_change.php", true);
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send("change1=" + encodeURIComponent(change1) +
                            "&cat_id=" + encodeURIComponent(id_cat)); 
                        }

                        function change_cat_to_no(event, id_cat) {                            
                            var change2 = document.getElementById('changes2').textContent;                            
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    location.reload();
                                }
                            };
                            xhttp.open("POST", "update/to_change.php", true);
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send("change2=" + encodeURIComponent(change2) +
                            "&cat_id=" + encodeURIComponent(id_cat)); 
                        }
                    </script>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.onload = function () {
            search();
        };

        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchTerm"); 
            filter = input.value.toUpperCase(); 
            table = document.getElementById("dataTable"); 
            tr = table.getElementsByTagName("tr"); 

            document.getElementById("searchResults").innerHTML = "<tr style='font-weight: bold;'> <td>№</td> <td>Категория</td> <td>Изображение</td> <td>Популярность</td> <td>Действие</td> </tr>";

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; 
                if (td) {
                    txtValue = td.textContent || td.innerText; 
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        document.getElementById("searchResults").innerHTML += tr[i].innerHTML;
                    }
                }
            }
        }
    </script>
</body>

</html>