<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Изменение категории</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/upd-cat.css">
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
                <a href="main.php">Администратор. Главная </a> > <a href="change-categories.php">Все категории</a> > Изменить данные о категории
            </div>

            <?php             
                require '../connect.php';

                if(isset($_GET["id"])) {

                    $campid = mysqli_real_escape_string($connect, $_GET["id"]);

                    $sql = "SELECT * FROM categories WHERE id_cat = '$campid'";

                    if($result = mysqli_query($connect, $sql)) {
                        if(mysqli_num_rows($result) > 0) {
                            foreach($result as $row) {
                                $id = $row['id_cat'];
                                $name = $row['category'];
                                $img_path = $row['img_cat'];
                            } 
                        }
                    }                    
                    ?>
            
    <div class="input">
        <div class="upd_form">
            <h2 style="padding: 10px 0px">Форма изменения категории</h2>
            <form id="upd" method="post" enctype="multipart/form-data" onsubmit="submitForm(event)">
                <input type='hidden' name='id' value='<?=$campid?>' />
                    <table class="tbl">
                        <tr>
                            <td style="width: 266px;">Тема:</td>
                            <td><input type='text' name='name' value='<?=$name?>'/></td>
                        </tr>
                    </table>

                    <div class="photo">Фото:</div>
                        <div>
                            <input type="file" id="photos" name="photos[]" accept="image/*" multiple style="font-size: 16px">
                            <div id="imageContainer">
                                <?php
                                    if (isset($img_path)&&($img_path!='')) {
                                        ?>
                                        <div class="imageWrapper" id="photo">
                                            <div class="deleteButton" onclick="deleteImage('<?= $img_path; ?>', '<?= $id; ?>')">✖</div>
                                            <img src="../<?= $img_path; ?>" style="width: 230px; height: 150px">
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>

                            <script>
                                var campid = <?= $campid; ?>;

                                function deleteImage(imgSrc, campId) {
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'update/delete_img_cat.php', true);
                                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    var params = 'imgSrc=' + encodeURIComponent(imgSrc) + '&campId=' + encodeURIComponent(campId);
                                    xhr.send(params);

                                    console.log(imgSrc, campId);

                                    xhr.onload = function() {
                                        if (xhr.status === 200) {
                                            console.log(xhr.responseText);
                                            var element = document.querySelector('[src="../' + imgSrc + '"]').closest('.imageWrapper');
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
                                    formData.append('campid', campid); 

                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'upload_cat_img.php', true);

                                    xhr.onreadystatechange = function () {
                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                            console.log('Изображение успешно загружено');
                                            console.log(xhr.response);
                                        }
                                    };

                                    xhr.send(formData);
                                }
                            </script>
                        </div>
                    </div>
                </form>              
                    
                    <input type='submit' form="upd" value='Сохранить изменения' onclick="submitForm(event)"> <br>
                    <a class="back" href="change-categories.php">Вернуться</a>
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

                            xhr.open("POST", "update/update_cat.php", true);
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