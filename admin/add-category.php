<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор. Добавление категории</title>

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="css/add-category.css">
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
                <a href="main.php">Администратор. Главная </a> > <a href="change-categories.php">Все категории</a> > Добавить категорию
            </div>
            
    <div class="input">
        <div class="add_form">
            <h2 style="padding: 10px 0px">Форма добавления категории</h2>
            <form id="add" method="post" enctype="multipart/form-data">
                    <table class="tbl">
                        <tr>
                            <td style="width: 266px;">Тема:</td>
                            <td><input type='text' name='name' required></td>
                        </tr>
                    </table>

                    <div class="photo">Фото:</div>
                        <div>
                            <input type="file" id="photos" name="photos[]" accept="image/*" multiple style="font-size: 16px" required>
                            <div id="imageContainer">
                                <?php
                                    if (isset($img_path)) {
                                        ?>
                                        <div class="imageWrapper" id="photo">
                                            <div class="deleteButton">✖</div>
                                            <img src="../<?= $img_path; ?>" style="width: 230px; height: 150px">
                                        </div>
                                        <?php
                                    }
                                ?>                                
                            </div>

                            <script>
                                document.getElementById('photos').addEventListener('change', handleImageSelect);

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
                        </div>
                    </div>
                </form>              
                    
                    <input type='submit' form="add" value='Добавить категорию'> <br>
                    <a class="back" href="change-categories.php">Вернуться</a>
                    <div id="result"></div>

                    <?php 
                    require '../connect.php';  
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $category = $_POST['name'];
                        
                            if (!empty($_FILES['photos']['name'][0])) {
                                $uploadDir = 'images/categories/';
                                $fileNames = $_FILES['photos']['name'];
                                $fileTmpNames = $_FILES['photos']['tmp_name'];
                                
                                foreach ($fileTmpNames as $key => $tmpName) {
                                    $fileName = basename($fileNames[$key]);
                                    $targetFile = $uploadDir . $fileName;
                                
                                    if (move_uploaded_file($tmpName, $targetFile)) {
                                
                                        $stmt = "INSERT INTO categories (category, img_cat, popular) VALUES ('$category', '$targetFile', 'no')";
                                        
                                        if (mysqli_query($connect, $stmt)) {    
                                            echo "Категория добавлена";
                                        } else {
                                            echo "Ошибка при загрузке файла на сервер: " . mysqli_error($connect);
                                        }
                                    } else {
                                        echo "Ошибка при загрузке файла на сервер!";
                                    }
                                }
                            } else {
                                echo 'Файлы не были загружены!';
                            }
                        }
                    ?>

            </div> 

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