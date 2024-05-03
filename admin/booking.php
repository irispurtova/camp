<?php require '../connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Просмотр заявок</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
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

    <div class="table-camp">
        <div class="container">
            <div class="bread-crumbs">
                <a href="main.php">Администратор. Главная </a> > Все заявки на бронирование
            </div>

            <h1 style="margin-bottom: 10px;">Все заявки на бронирование</h1>
            
            <form action="search.php" method="post">
                <label for="searchTerm">Поиск по названию лагеря:</label>
                <input type="text" id="searchTerm" oninput="search()" required style='font-size: 18px;'>
                <button type="submit" style="display: none">Поиск</button>
            </form>

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
                        <td>Название лагеря</td>
                        <td>Имя родителя</td>
                        <td>Имя ребенка</td>
                        <td>Сезон</td>
                        <td>Цена</td>
                        <td>E-mail</td>
                        <td>Телефон</td>
                        <td>Возраст ребенка</td>

                    </tr>
                </thead>
                <tbody>
                    <?php
                        $table_sql = "SELECT * FROM booking";
                        $res_table = mysqli_query($connect, $table_sql);
                        $count=0;

                        if ($res_table) {
                            $count=1;
    
                            while($row = mysqli_fetch_assoc($res_table)) {   
                                $name_camp = $row['name_camp'];
                                $name_parent = $row['name_parent'];
                                $name_child = $row['name_child'];
                                $season = $row['season'];
                                $price = $row['price'];
                                $telephone = $row['telephone'];
                                $email = $row['email'];
                                $child_age = $row['child_age'];?>
                                
                                <tr>
                                    <td><?=$count;?></td>
                                    <td><?=$name_camp;?></td>
                                    <td><?=$name_parent;?></td>
                                    <td><?=$name_child;?></td>
                                    <td><?=$season;?></td>
                                    <td><?=$price;?></td>
                                    <td><?=$telephone;?></td>
                                    <td><?=$email;?></td>
                                    <td><?=$child_age;?></td>
                                </tr> <?php
                                $count++;
                            } 
                            
                        }
                    ?>
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

            document.getElementById("searchResults").innerHTML = "<tr style='font-weight: bold;'> <td>№</td> <td>Название лагеря</td> <td>Имя родителя</td> <td>Имя ребенка</td> <td>Сезон</td> <td>Цена</td> <td>E-mail</td> <td>Телефон</td> <td>Возраст ребенка</td> </tr>";

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