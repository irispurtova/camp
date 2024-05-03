<?php require '../connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Все лагеря</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/bd.css">
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
                <a href="main.php">Администратор. Главная </a> > Все лагеря
            </div>
            <h1>Все лагеря</h1>

            <?php
                if (isset($_GET['del'])) {
                    $pr_del = $_GET['del'];

                    $query = "DELETE FROM camps WHERE id = $pr_del";
                    mysqli_query($connect, $query) or die(mysqli_error($connect));

                    $query1 = "DELETE FROM price WHERE id_camp = $pr_del";
                    mysqli_query($connect, $query) or die(mysqli_error($connect));
                }
            ?>

            <div class="razdel">
                <div class="left">
                    <div class="all-types">
                        <h2 style="padding: 10px 0px;">Поиск по фильтрам: </h2>

                        <form action="search.php" method="post">
                            <label for="searchTerm">Введите название лагеря для поиска:</label>
                            <input type="text" id="searchTerm" oninput="search()" required style='font-size: 18px;'>
                            <button type="submit" style="display: none">Поиск</button>
                        </form>

                        <form id="searchForm">                            
                            <?php
                                $sql = "SELECT * FROM categories";
                                $result = mysqli_query($connect, $sql);

                                if(mysqli_num_rows($result) > 0) {
                                    foreach($result as $row) { ?>
                                        <label>
                                            <input type="checkbox" value="<?=$row['category'];?>" class="categoryCheckbox"> <?=$row['category'];?>
                                        </label>
                                    <?php                            
                                    } 
                                }
                            ?>
                            <button type="button" id="resetButton" onclick="resetFilters()">Сбросить фильтры</button>
                        </form>
                    </div>


                    <div class="b" style="margin-top: 10px;">
                        <a class="button-add" href="add-camp.php">
                            Добавить лагерь</a>
                    </div>
                </div>

                <div class="table">
                    <table class="table" id="searchResults" style="width: 711px"></table>
                </div>

                <table id="dataTable" style="display: none;" class="right">
                    <thead>
                        <tr>
                            <td>№</td>
                            <td>Название</td>
                            <td>Возраст</td>
                            <td>Тип лагеря</td>
                            <td>Действие</td>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $table_sql = "SELECT id, name, age_from, age_to, category FROM camps";
                            $res_table = mysqli_query($connect, $table_sql);
                            $count=0;

                            if ($res_table) {
                                $count=1;
        
                                while($row = mysqli_fetch_assoc($res_table)) {
                                    $id=$row['id'];   
                                    $name=$row['name'];
                                    $age_from=$row['age_from'];
                                    $age_to=$row['age_to'];
                                    $category=$row['category'];?>
                                    
                                    <tr>
                                        <td><?=$count;?></td>
                                        <td><?=$name;?></td>
                                        <td>от <?=$age_from;?> до <?=$age_to;?> лет</td>
                                        <td><?=$category;?></td>
                                        <td><a href="upd-camp.php?id=<?=$id?>">Изменить </a> / <a href="?del=<?=$id?>" onclick="return confirm('Вы уверены?');">Удалить</a></td>
                                    </tr> <?php
                                    $count++;
                                } 
                                
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
            search();
        };

        function search() {
            // Получаем элементы: поле ввода, фильтр, таблицу, строки таблицы и ячейки
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchTerm"); // Получаем элемент ввода (поиск)
            filter = input.value.toUpperCase(); // Получаем значение из поля ввода и преобразуем его в верхний регистр
            table = document.getElementById("dataTable"); // Получаем таблицу
            tr = table.getElementsByTagName("tr"); // Получаем строки таблицы

            // Очищаем таблицу результатов
            document.getElementById("searchResults").innerHTML = "<tr> <td>№</td> <td>Название лагеря</td> <td>Возраст</td> <td>Тематика</td> <td>Действие</td> </tr>";

            // Перебираем все строки таблицы
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Получаем вторую ячейку (столбец) строки
                if (td) {
                    txtValue = td.textContent || td.innerText; // Получаем текстовое содержимое ячейки
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        // Если текст содержит в себе значение фильтра (поиска), добавляем строку в таблицу результатов
                        document.getElementById("searchResults").innerHTML += tr[i].innerHTML;
                    }
                }
            }
        }

        // Добавление обработчика события для чекбоксов
        document.addEventListener('DOMContentLoaded', function () {
            var checkboxes = document.getElementsByClassName('categoryCheckbox');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].addEventListener('change', searchCamps);
            }
        });

        // Функция поиска в таблице "тематика" по выбранным чекбоксам
        function searchCamps() {
            var selectedCategories = []; // Массив для хранения выбранных значений чекбоксов
            var checkboxes = document.getElementsByClassName('categoryCheckbox');

            // Собираем выбранные значения чекбоксов
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    selectedCategories.push(checkboxes[i].value);
                }
            }

            // Получаем таблицу "тематика"
            var categoryTable = document.getElementById('searchResults');

            // Очищаем таблицу результатов
            categoryTable.innerHTML = "<tr> <td>№</td> <td>Название лагеря</td> <td>Возраст</td> <td>Тематика</td> <td>Действие</td> </tr>";

            // Перебираем все строки в основной таблице "camps"
            var mainTableRows = document.getElementById('dataTable').getElementsByTagName('tr');
            for (var i = 1; i < mainTableRows.length; i++) {
                var categoryCell = mainTableRows[i].getElementsByTagName('td')[3]; // Получаем ячейку с тематикой
                if (categoryCell) {
                    var categoryValue = categoryCell.textContent || categoryCell.innerText;
                    var categoryArray = categoryValue.split(' '); // Разделяем строку на массив тематик

                    // Проверяем, содержит ли хотя бы одна тематика выбранные значения чекбоксов
                    if (selectedCategories.length === 0 || selectedCategories.some(category => categoryArray.includes(category))) {
                        categoryTable.innerHTML += mainTableRows[i].innerHTML;
                    }
                }
            }
        }

        // Функция сброса фильтров
        function resetFilters() {
            var checkboxes = document.getElementsByClassName('categoryCheckbox');
            var searchTermInput = document.getElementById('searchTerm');

            // Сбрасываем все чекбоксы
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }

            // Сбрасываем введенное значение в поле поиска
            searchTermInput.value = '';

            // Вызываем функцию поиска снова, чтобы вернуть таблицу к исходному состоянию
            searchCamps();
        }
    </script>
</body>

</html>