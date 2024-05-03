<?php
require '../connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Добавление</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/add-camp.css">
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
        <div class="container" style="width: 90%">
            <div class="bread-crumbs">
                <a href="main.php">Администратор. Главная </a> > <a href="bd.php">Все лагеря</a> > Добавить лагерь
            </div>

            <form method="post" enctype="multipart/form-data" id="add">
            <table class="tbl">
                <tr>
                    <td style="width: 266px;">Название лагеря:</td>
                    <td><input type='text' name='name' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Страна:</td>
                    <td><input type='text' name='country' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Регион:</td>
                    <td><input type='text' name='region' required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Город:</td>
                    <td><input type='text' name='city' required/></p></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Возраст:</td>
                    <td class="age-inputs">
                        <input type="number" name="age_from" placeholder="От" min="3" max="18" required>
                        <input type="number" name="age_to" placeholder="До" min="3" max="18" required>
                    </td>
                </tr>
                <tr>
                <tr>
                    <td style="width: 266px;">Сезон:</td>
                    <td>
                        <select id="season_select" style="padding: 8px; font-size: 16px;">
                            <option value="summer">Летний</option>
                            <option value="autumn">Осенний</option>
                            <option value="winter">Зимний</option>
                            <option value="spring">Весенний</option>
                        </select>
                        <button onclick="addSeason()" style="padding: 5px; font-size: 16px;">Добавить сезон</button>

                        <table id="season_table"></table>
                    </td>
                </tr>
                    <script>
                        function addSeason() {
                            var seasonSelect = document.getElementById("season_select");
                            var selectedSeason = seasonSelect.value;
                            var seasonOption = seasonSelect.options[seasonSelect.selectedIndex];
                            var seasonText = seasonOption.text;
                            
                            var existingSeasons = document.getElementsByClassName("season-row");
                            for (var i = 0; i < existingSeasons.length; i++) {
                                if (existingSeasons[i].dataset.season === selectedSeason) {
                                    alert("Этот сезон уже добавлен.");
                                    return;
                                }
                            }
                            
                            var table = document.getElementById("season_table");
                            var newRow = table.insertRow(-1);
                            newRow.className = "season-row";
                            newRow.dataset.season = selectedSeason;
                            
                            var cell1 = newRow.insertCell(0);
                            var cell2 = newRow.insertCell(1);
                            
                            cell1.innerHTML = seasonText + " сезон цена:";
                            cell2.innerHTML = "<input type='number' name='" + selectedSeason + "_price' required>";

                            var hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'selectedSeason';
                            hiddenInput.value = selectedSeason;
                            newRow.appendChild(hiddenInput);
                        }
                    </script>
                <tr>
                    <td style="width: 266px;">Тематика лагеря:</td>
                    <td>
                        <?php
                            $query = "SELECT * FROM categories";
                            if ($result = mysqli_query($connect, $query)) {
                                while($row = mysqli_fetch_assoc($result)) { ?>
                                    <label>
                                        <input type="checkbox" name="category[]" value="<?=$row['category'];?>">&nbsp<?=$row['category'];?>
                                    </label> <br>
                                <?php
                                }
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 266px;">Краткое описание:</td>
                    <td><textarea name='desc_card' rows="4" required></textarea></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Описание программы:</td>
                    <td><textarea name='description' rows="6" required></textarea></td>
                </tr>
            </table>

            <div class="photo">Фото:</div>
                <div>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple required style="font-size: 16px">
                    <div id="imageContainer"></div>
                </div>
        </form>

        <input type='submit' form="add" value='Добавить лагерь'><br><br>
        <a class="back" href="bd.php">Вернуться</a>

        <script>
            document.getElementById('images').addEventListener('change', handleImageSelect);

            function handleImageSelect(event) {
                var files = event.target.files;

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    displayImage(file);
                }
            }

            function displayImage(file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var imageSrc = e.target.result;

                    var imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('imageWrapper');

                    var deleteButton = document.createElement('button');
                    deleteButton.classList.add('deleteButton');
                    deleteButton.innerHTML = '✖';

                    deleteButton.addEventListener('click', function () {
                        imageWrapper.remove();
                    });

                    var imageElement = document.createElement('img');
                    imageElement.src = imageSrc;

                    imageWrapper.appendChild(deleteButton);
                    imageWrapper.appendChild(imageElement);
                    document.getElementById('imageContainer').appendChild(imageWrapper);
                };

                reader.readAsDataURL(file);
            }
        </script>

        <?php   
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $country = $_POST['country'];
            $region = $_POST['region'];
            $city = $_POST['city'];
            $age_from = $_POST['age_from'];
            $age_to = $_POST['age_to'];
            $category = isset($_POST['category']) ? implode(" ", $_POST['category']) : "";
            $description = $_POST['description'];
            $desc_card = $_POST['desc_card'];
            $selectedSeason = $_POST['selectedSeason'];
            $seasonPrice = $_POST[$selectedSeason . "_price"];
            $seasonTranslations = array(
                "summer" => "Летний",
                "autumn" => "Осенний",
                "winter" => "Зимний",
                "spring" => "Весенний"
            );            
            $selectedSeasonTranslation = isset($seasonTranslations[$_POST['selectedSeason']]) ? $seasonTranslations[$_POST['selectedSeason']] : "";

            $connect->begin_transaction();

            try {
                $sqlTest = "INSERT INTO camps (name, country, region, city, category, age_from, age_to, description, desc_card) 
                VALUES ('$name', '$country', '$region', '$city', '$category', '$age_from', '$age_to', '$description', '$desc_card')";
                if ($connect->query($sqlTest) !== TRUE) {
                    throw new Exception("Ошибка при добавлении данных в таблицу 'camps': " . $connect->error);
                }
            
                $lastInsertedId = $connect->insert_id;

                $sqlInsertPrice = "INSERT INTO price (id_camp, name, season, price) VALUES ('$lastInsertedId', '$name', '$selectedSeasonTranslation', '$seasonPrice')";
                if ($connect->query($sqlInsertPrice) !== TRUE) {
                    throw new Exception("Ошибка при добавлении данных в таблицу 'price': " . $connect->error);
                }

                $folderName = str_replace(' ', '', $name);

                $targetDirectory = "images/lagerya/";

                if (!file_exists($targetDirectory . $folderName)) {
                    mkdir($targetDirectory . $folderName, 0777, true);
                }

                $newDirectory = $targetDirectory . $folderName . '/';
                $uploadedImages = [];
            
                foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
                    $fileName = basename($_FILES["images"]["name"][$key]);
                    $targetFilePath = $newDirectory . $fileName;
            
                    if (move_uploaded_file($tmp_name, $targetFilePath)) {
                        $uploadedImages[] = $targetFilePath;
            
                        if ($key === 0) {
                            $logoPath = $targetFilePath;

                            $sqlUpdateLogo = "UPDATE camps SET logo = '$logoPath' WHERE id = '$lastInsertedId'";

                            if ($connect->query($sqlUpdateLogo) !== TRUE) {
                                throw new Exception("Ошибка при обновлении логотипа в таблице 'camps': " . $connect->error);
                            }
                        } else {
                            $sqlImages = "INSERT INTO images (id, source) VALUES ('$lastInsertedId', '$targetFilePath')";
                            if ($connect->query($sqlImages) !== TRUE) {
                                throw new Exception("Ошибка при добавлении изображения в таблицу 'images': " . $connect->error);
                            }
                        }
                    } else {
                        throw new Exception("Ошибка при загрузке изображения $fileName.");
                    }
                }
            
                $connect->commit();
            } catch (Exception $e) {
                $connect->rollback();
                echo "Ошибка: " . $e->getMessage();
            }
            
            echo "<br>" . "Лагерь $name успешно добавлен!";
            
            $connect->close(); 
        }?>
            
    </div>

    <!-- запрет на повторную отправку формы при перезагрузке -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
        </div>
    </div>
</body>

</html>