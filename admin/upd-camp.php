<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Изменение</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/upd-camp.css">
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
                <a href="main.php">Администратор. Главная </a> > <a href="bd.php">Все лагеря</a> > Изменить данные о лагере
            </div>

            <?php 
            
                require '../connect.php';

                if(isset($_GET["id"])) {

                    $campid = mysqli_real_escape_string($connect, $_GET["id"]);

                    $sql = "SELECT * FROM camps WHERE id = '$campid'";

                    if($result = mysqli_query($connect, $sql)) {
                        if(mysqli_num_rows($result) > 0) {
                            foreach($result as $row) {
                                $id = $row['id'];
                                $name = $row["name"];
                                $logo = $row["logo"];
                                $country = $row["country"];
                                $region = $row["region"];
                                $city = $row["city"];
                                $category = $row["category"];
                                $minAge = $row["age_from"];
                                $maxAge = $row["age_to"];
                                $desc_card = $row["desc_card"];
                                $description = $row['description'];
                            } 
                        }
                    }

                    $sql_img = "SELECT source FROM images WHERE id = '$campid'";
                    $result_img = $connect->query($sql_img);

                    if ($result->num_rows > 0) {
                        while($row = $result_img->fetch_assoc()) {
                            $imagePath = $row["source"];
                            $imagePaths[] = $imagePath;
                        }
                    } else {
                        echo "Нет данных";
                    }

                    $Photos = mysqli_query($connect, "SELECT * FROM `images` WHERE `id`='$campid'");    
                    $Photos = mysqli_fetch_all($Photos, MYSQLI_ASSOC);
                    
                    ?>
            
    <div class="input">
        <div class="upd_form">
            <h2 style="padding: 10px 0px">Форма изменения данных о лагере "<?= $name ?>"</h2>
            <!-- форма для обновления вводимых текстовых данных -->
            <form id="upd" method="post" enctype="multipart/form-data" onsubmit="submitForm(event)">
                <input type='hidden' name='id' value='<?=$campid?>' />
                    <table class="tbl">
                        <tr>
                            <td style="width: 266px;">Название лагеря:</td>
                            <td><input type='text' name='name' value='<?=$name?>'/></td>
                        </tr>
                        <tr>
                            <td style="width: 266px;">Страна:</td>
                            <td><input type='text' name='country' value='<?=$country?>'/></td>
                        </tr>
                        <tr>
                            <td style="width: 266px;">Регион:</td>
                            <td><input type='text' name='region' value='<?=$region?>'/></td>
                        </tr>
                        <tr>
                            <td style="width: 266px;">Город:</td>
                            <td><input type='text' name='city' value='<?=$city?>'/></p></td>
                        </tr>
                        <tr>
                            <td style="width: 266px;">Возраст:</td>
                            <td class="age-inputs">
                                <input type="number" name="age_from" placeholder="От" min="3" max="18" value='<?=$minAge?>'>
                                <input type="number" name="age_to" placeholder="До" min="3" max="18" value='<?=$maxAge?>'>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td style="width: 266px;">Сезон:</td>
                            <td>
                                <?php
                                $sql = "SELECT * FROM price WHERE id_camp = '$id'";
                                $result = $connect->query($sql);
                                
                                if ($result->num_rows > 0) {
                                    $inputsHtml = "";
                                
                                    while ($row = $result->fetch_assoc()) {
                                        $season = $row["season"];
                                        $price = $row["price"];

                                        $inputsHtml .= "<div class='inputs_select' style='display: flex; flex-direction: row; align-items: center; padding: 10px 0px;'> <div class='text_select' style='width: 178px'>$season сезон цена: </div>";
                                
                                        $inputsHtml .= "<input type='number' name='" . $season . "_price' value='" . $price . "' required style='width: 140px;'></div>";
                                    }
                                
                                    echo $inputsHtml;
                                } else {
                                    echo "Нет данных";
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 266px;">Тематика лагеря:</td>
                            <td>
                            <?php
                                $query_camps = "SELECT category FROM camps WHERE id = '$campid'";
                                $result_camps = mysqli_query($connect, $query_camps);

                                $selected_categories = array();
                                while($row_camps = mysqli_fetch_assoc($result_camps)) {
                                    $categories_array = explode(" ", $row_camps['category']);
                                    
                                    foreach ($categories_array as $category_word) {
                                        $selected_categories[] = $category_word;
                                    }
                                }

                                $selected_categories = array_unique($selected_categories);

                                $query = "SELECT * FROM categories";
                                if ($result = mysqli_query($connect, $query)) {
                                    while($row = mysqli_fetch_assoc($result)) { ?>
                                        <label>
                                            <input type="checkbox" name="category[]" value="<?=$row['category'];?>" <?php if(in_array($row['category'], $selected_categories)) echo "checked"; ?>>&nbsp<?=$row['category'];?>
                                        </label> <br>
                                    <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 266px;">Краткое описание:</td>
                            <td><textarea name='desc_card' rows="4" required><?=$desc_card?></textarea></td>
                        </tr>
                        <tr>
                            <td style="width: 266px;">Описание программы:</td>
                            <td><textarea name='description' rows="6" required><?=$description?></textarea></td>
                        </tr>
                    </table>

                    <div class="photo">Фото:</div>
                        <div>
                            <input type="file" id="photos" name="photos[]" accept="image/*" multiple style="font-size: 16px">
                            <div id="imageContainer">

                            <?php
                            foreach($Photos as $key => $value) {?> 

                                    <div class="imageWrapper" id="photo_<?= $key + 1 ?>">
                                        <div class="deleteButton" onclick="deleteImage('<?= $value['source']; ?>', '<?= $campid; ?>')">✖</div>
                                        <img src="<?= $value['source']; ?>">
                                    </div> <?php
                                
                            }
                            ?> </div>

                            <script>
                                var campid = <?= $campid; ?>;

                                function deleteImage(imgSrc, campId) {
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'update/delete_image.php', true);
                                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    var params = 'imgSrc=' + encodeURIComponent(imgSrc) + '&campId=' + encodeURIComponent(campId);
                                    xhr.send(params);

                                    xhr.onload = function() {
                                        if (xhr.status === 200) {
                                            console.log(xhr.responseText);
                                            var element = document.querySelector('[src="' + imgSrc + '"]').closest('.imageWrapper');
                                            if (element) {
                                                element.parentNode.removeChild(element);
                                            }
                                        }
                                    };
                                }

                                document.getElementById('photos').addEventListener('change', handleImageSelect);

                                function handleImageSelect(event) {
                                    var files = event.target.files;

                                    for (var i = 0; i < files.length; i++) {
                                        var file = files[i];
                                        displayImage(file);
                                        uploadImage(file, campid);
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

                                function uploadImage(file, campid) {
                                    var formData = new FormData();
                                    formData.append('image', file);
                                    formData.append('campid', campid); // идентификатор пользователя в FormData

                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'upload_img.php', true);

                                    xhr.onreadystatechange = function () {
                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                            console.log('Изображение успешно загружено');
                                        }
                                    };

                                    xhr.send(formData);
                                    }
                            </script>
                        </div>
                    </div>
                </form>              
                    
                    <input type='submit' form="upd" value='Сохранить изменения' onclick="submitForm(event)"> <br>
                    <a class="back" href="bd.php">Вернуться</a>
                    <div id="result"></div>

                    <script>
                        function submitForm(event) {
                            event.preventDefault();
                            var form = document.getElementById("upd");
                            var formData = new FormData(form);

                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function () {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    console.log(xhr.responseText);
                                    document.getElementById("result").innerHTML = 'Данные успешно обновлены!'
                                }
                            };

                            xhr.open("POST", "update/update_form.php", true);
                            xhr.send(formData);
                        }
                    </script>

            </div> 
    <?php 
    }?>

    </div>

    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

        </div>
    </div>
</body>

</html>