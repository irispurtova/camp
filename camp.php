<?php 
require 'connect.php';
session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') {
    $user_name = $_SESSION['auth'];
}

$userid = mysqli_real_escape_string($connect, $_GET["id"]);

$sql = "SELECT camps.*, images.source
        FROM camps
        LEFT JOIN images ON camps.id = images.id
        WHERE camps.id = $userid";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $row["name"];
        $logo = $row["logo"];
        $country = $row["country"];
        $region = $row["region"];
        $city = $row["city"];
        $category = $row["category"];
        $desc = $row['description'];   
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница лагеря</title>

    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/camp.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
    <?php require 'header.php'; ?>

    <div class="inner">
        <div class="container">
            <div class="bread-crumbs">
                <p style="font-size: 12px;">
                    <a href="lagerya.php" style="color: #585858;">Все лагеря > </a><?=$name;?>
                </p>
            </div>

            <h1 style="font-size: 32px; padding-top: 10px;"><?=$name;?></h1>
            
            <p>Адрес: <?php echo $country . ', ' . $region . ', ' . $city; ?></p>

            <?php
                $sql2 = "SELECT category FROM camps WHERE name='$name'";
                $result2 = $connect->query($sql2);
                
                if ($result2->num_rows > 0) {
                    echo '<div class="cat">';
                    while($row = $result2->fetch_assoc()) {
                        $categories = explode(' ', $row['category']);
                        foreach ($categories as $category) {
                            echo '<div class="cat-block">' . $category . '</div>';
                        }
                    }
                    echo '</div>';
                }
            ?>

            <!-- Модальное окно для увеличенного изображения -->
            <div class="modal-gallery">
                <div id="imageModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeImageModal">&times;</span>
                        <button id="prevImage" class="arrow-button left-arrow">⮜ </button>
                        <img id="zoomedImage" src="" alt="Zoomed Image">
                        <button id="nextImage" class="arrow-button right-arrow"> ⮞</button>
                        <div id="imageCounter" class="image-counter"></div>
                    </div>
                </div>
            </div>

            <?php 
                $sql = "SELECT source FROM images WHERE id = $userid LIMIT 7";
                $result = $connect->query($sql); 
                $i = 0;                
            ?>

            <div class="card-info">
                <div class="left">
                    <!-- Галерея изображений на странице -->
                    <div class="gallery">
                        <div class="the-main-photo" style="background-image: url('admin/<?=$logo;?>'); background-repeat: no-repeat; background-size: cover;">
                            <?php
                            if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') {
                                $fav = "SELECT * FROM user_favorite WHERE camp_name = '$name'";
                                $res_fav = $connect->query($fav);
                                
                                if ($res_fav->num_rows > 0) {
                                    $row_fav = $res_fav->fetch_assoc(); ?>
                                    <div id="heart" class="heart-icon red-heart" onclick="delFavorite('<?=$name;?>')">&#x2764;&#xFE0F;</div>
                                    <?php
                                } else { ?>
                                    <div id="heart" class="heart-icon" onclick="addFavorite('<?=$name;?>')">&#x1F49B;</div>
                                <?php
                                }
                            }
                            ?>   
                        </div>

                        <div class="block-photos">
                            <!-- Показываем только 7 изображений -->
                            <?php
                                while ($row = $result->fetch_assoc()) { ?>
                                    <div class="gallery-item zoomable" data-index="<?=$i;?>" style="cursor: pointer;"><img src="admin/<?=$row['source'];?>" alt="Image <?=$i+1;?>"></div> <?php
                                    $i++;
                                }
                            ?>
                            <div class="remaining-images" data-total="7"></div>

                            <div class="hidden-images">
                                <!-- Скрытые изображения -->
                                <?php
                                    $sql4 = "SELECT * FROM images WHERE id = $id ORDER BY id ASC LIMIT 7, 18446744073709551615";
                                    $result4 = mysqli_query($connect, $sql4);
                                    $i = 8;                                

                                    while ($row_hidden = $result4->fetch_assoc()) { ?>
                                        <div class="gallery-item zoomable" data-index="3">
                                            <img src="admin/<?=$row_hidden['source'];?>" alt="Image <?=$i;?>">
                                        </div> <?php
                                        $i++;
                                    }
                                ?>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var zoomableImages = document.querySelectorAll('.gallery-item.zoomable img');
                                var hiddenImages = document.querySelectorAll('.hidden-images img');
                                var imageModal = document.getElementById('imageModal');
                                var closeImageModal = document.getElementById('closeImageModal');
                                var zoomedImage = document.getElementById('zoomedImage');
                                var prevButton = document.getElementById('prevImage');
                                var nextButton = document.getElementById('nextImage');
                                var remainingImagesBlock = document.querySelector('.remaining-images');
                                var imageCounter = document.getElementById('imageCounter');
                                var currentIndex = 0;

                                // Скрываем изображения при загрузке страницы
                                hiddenImages.forEach(function (image) {
                                    image.style.display = 'none';
                                });

                                // Пересчитываем оставшееся количество и обновляем его
                                function updateRemainingImages() {
                                    var remainingCount = hiddenImages.length;
                                    remainingImagesBlock.textContent = 'Ещё ' + remainingCount + ' фото';
                                }

                                // Перебираем все изображения и добавляем обработчик событий
                                zoomableImages.forEach(function (image, index) {
                                    image.addEventListener('click', function () {
                                        currentIndex = index;
                                        showImage(index);
                                        imageModal.style.display = 'block';
                                        updateButtons();
                                        updateRemainingImages();
                                        updateImageCounter();
                                    });
                                });

                                // Функция отображения текущего изображения
                                function showImage(index) {
                                    var originalSrc = zoomableImages[index].src;
                                    zoomedImage.src = originalSrc;
                                }

                                // Обработчик события для кнопки "Влево"
                                prevButton.addEventListener('click', function () {
                                    currentIndex = (currentIndex - 1 + zoomableImages.length) % zoomableImages.length;
                                    showImage(currentIndex);
                                    updateButtons();
                                    updateRemainingImages();
                                    updateImageCounter();
                                });

                                // Обработчик события для кнопки "Вправо"
                                nextButton.addEventListener('click', function () {
                                    currentIndex = (currentIndex + 1) % zoomableImages.length;
                                    showImage(currentIndex);
                                    updateButtons();
                                    updateRemainingImages();
                                    updateImageCounter();
                                });

                                // Закрываем модальное окно с увеличенным изображением
                                closeImageModal.addEventListener('click', function () {
                                    imageModal.style.display = 'none';
                                });

                                // Закрываем модальное окно при клике за его пределами
                                window.addEventListener('click', function (event) {
                                    if (event.target === imageModal) {
                                        imageModal.style.display = 'none';
                                    }
                                });

                                // Обработчик события клавиатуры
                                document.addEventListener('keydown', function (event) {
                                    if (imageModal.style.display === 'block') {
                                        switch (event.key) {
                                            case 'ArrowLeft':
                                                prevButton.click();
                                                break;
                                            case 'ArrowRight':
                                                nextButton.click();
                                                break;
                                            case 'Escape':
                                                closeImageModal.click();
                                                break;
                                        }
                                    }
                                });

                                // Обновление состояния кнопок
                                function updateButtons() {
                                    // Всегда разрешаем перелистывание вперед
                                    nextButton.disabled = false;

                                    // Разрешаем перелистывание назад, если не первая картинка
                                    prevButton.disabled = currentIndex === 0;
                                }

                                // Отображение всех изображений при клике на блок "remaining-images"
                                remainingImagesBlock.addEventListener('click', function () {
                                    currentIndex = 0;
                                    showImage(currentIndex);
                                    imageModal.style.display = 'block';
                                    updateButtons();
                                    updateRemainingImages();
                                    updateImageCounter();
                                });

                                // Обновление номера текущей картинки относительно общего числа картинок
                                function updateImageCounter() {
                                    var currentImageNumber = currentIndex + 1;
                                    var totalVisibleImages = zoomableImages.length;
                                    imageCounter.textContent = currentImageNumber + '/' + totalVisibleImages;
                                }

                                // Инициализация оставшегося количества и номера текущей картинки при загрузке страницы
                                updateRemainingImages();
                                updateImageCounter();
                            });

                        </script>
                    </div>

                    <div class="text"><?=htmlspecialchars_decode($desc);?></div>
                </div>

                <div class="right">
                    <div class="characteristics">
                        <div class="styled-select" id="styled-select<?=$i;?>">
                            <div class="title">Сезоны лагеря:</div>
                            <?php
                                $initialSeason = "";
                                $initialPrice = "";

                                $sql3="SELECT season, price FROM price WHERE name='$name'";
                                $result3 = $connect->query($sql3);

                                if ($result3->num_rows > 0) {
                                    $row = $result3->fetch_assoc();
                                    $initialSeason = $row['season'];
                                    $initialPrice = $row['price'];
                                }
                            ?>
                            <div class="selected-option"><?php echo $initialSeason !== "" ? $initialSeason.' - '.number_format($initialPrice, 0, '.', ' ').' ₽' : ''; ?></div>
                            <div class="options-container" id="ooo<?=$i;?>">
                                <?php
                                    $sql4="SELECT season, price FROM price WHERE name='$name'";
                                    $result4 = $connect->query($sql4);

                                    if ($result4->num_rows > 0) {
                                        while($row = $result4->fetch_assoc()) { 
                                            $season = $row['season'];
                                            $price = $row['price'];?>

                                            <div data-value="value1"><?php echo $season.' - '.number_format($price, 0, '.', ' ').' ₽'; ?></div> <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <div id="price" class="price<?=$i;?>">
                            <div class="top" style="font-size: 42px"></div>
                        </div>
                    </div>

                    <a class="link-question">
                        <div class="booking" id="reserveButton" onclick="openBookingModal(<?php echo $i; ?>, '<?php echo $name; ?>')">
                            ЗАБРОНИРОВАТЬ
                        </div>
                    </a>

                    <div class="button-add-feedback"><a href="add-feedback.php?id=<?=$id;?>" style="color: #1950a0">ДОБАВИТЬ ОТЗЫВ</a></div>

                    <!-- Модальное окно -->
                    <?php require 'modal_booking.php'; ?>

                    <script>
                            // Функция открытия модального окна
                            function openBookingModal(index, name) {
                                // Получаем элементы modal и modalContent
                                var modal = document.getElementById('myModal');
                                var modalContent = modal.querySelector('#modalContent');

                                // Получаем данные для заполнения блока .styled-select
                                var selectedOption = document.getElementById('styled-select' + index).querySelector('.selected-option').textContent;
                                var optionsContainerHTML = document.getElementById('ooo' + index).innerHTML;

                                // Генерируем HTML для блока .styled-select в модальном окне
                                var styledSelectHTML = '<h2>' + name + '</h2>';
                                styledSelectHTML += '<input type="hidden" name="name_camp" id="name_camp" value="' + name + '">';
                                styledSelectHTML += '<div class="styled-select" id="modalStyledSelect" style="width: 298px; background: white; cursor: auto; margin: 0">';        
                                styledSelectHTML += '<div class="title">Выбранный сезон:</div>';
                                styledSelectHTML += '<div class="selected-option">' + selectedOption + '</div>';
                                styledSelectHTML += '<div class="options-container">' + optionsContainerHTML + '</div>';
                                styledSelectHTML += '</div>';

                                // Заполняем модальное окно сгенерированным HTML
                                modalContent.innerHTML = styledSelectHTML;

                                // Открываем модальное окно
                                modal.style.display = 'block';
                            }

                            // Функция закрытия модального окна
                            function closeBookingModal() {
                                var modal = document.getElementById('myModal');
                                modal.style.display = 'none';
                            }

                            // Закрытие модального окна при клике за его пределами
                            window.onclick = function(event) {
                                var modal = document.getElementById('myModal');
                                if (event.target === modal) {
                                    modal.style.display = 'none';
                                }
                            };

                            function submitBooking(event) {
                                event.preventDefault();

                                var tel = document.getElementById('tel').value;
                                var email = document.getElementById('email').value;
                                var nameParent = document.getElementById('nameParent').value;
                                var nameChild = document.getElementById('nameChild').value;
                                var childAge = document.getElementById('childAge').value;
                                var name_camp = document.getElementById('name_camp').value;

                                var selectedOption = document.getElementById('modalStyledSelect').querySelector('.selected-option').textContent;
                                var season = selectedOption.split(' - ')[0];

                                // Remove spaces and currency symbols from the price
                                var price = selectedOption.split(' - ')[1].replace(/\s+/g, '').replace(/[^\d.]/g, '');

                                // Создаем объект XMLHttpRequest
                                var xhr = new XMLHttpRequest();

                                // Устанавливаем метод, URL и асинхронность запроса
                                xhr.open('POST', 'server/add_booking.php', true);

                                // Устанавливаем заголовок Content-Type для отправки POST-запроса
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                // Отправляем запрос
                                xhr.send('tel=' + encodeURIComponent(tel) + 
                                '&email=' + encodeURIComponent(email) + 
                                '&nameParent=' + encodeURIComponent(nameParent) + 
                                '&nameChild=' + encodeURIComponent(nameChild) +
                                '&childAge=' + encodeURIComponent(childAge) +
                                '&season=' + encodeURIComponent(season) + 
                                '&price=' + encodeURIComponent(price) +
                                '&name_camp=' + encodeURIComponent(name_camp));

                                // Опционально: обработка ответа от сервера
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        // Обработка успешного ответа                                        
                                        alert(xhr.responseText);
                                        resetModalBooking();
                                        // Дополнительные действия, если необходимо
                                    } else if (xhr.readyState === 4 && xhr.status !== 200) {
                                        // Обработка ошибки
                                        console.error('Ошибка при выполнении запроса');
                                    }
                                };
                            }

                            function resetModalBooking() {
                                // Сбрасываем значения полей формы
                                document.getElementById('tel').value = '';
                                document.getElementById('email').value = '';
                                document.getElementById('nameParent').value = '';
                                document.getElementById('nameChild').value = '';
                                document.getElementById('childAge').value = '';
                            }
                        </script>


                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var styledSelects = document.querySelectorAll('.styled-select');

                                styledSelects.forEach(function (styledSelect) {
                                    var optionsContainer = styledSelect.querySelector('.options-container');
                                    var selectedOption = styledSelect.querySelector('.selected-option');
                                    var topElement = styledSelect.nextElementSibling.querySelector('.top'); // Получаем .top

                                    // Добавляем обработчик события клика по styled-select
                                    styledSelect.addEventListener('click', function () {
                                        styledSelects.forEach(function (otherStyledSelect) {
                                            if (otherStyledSelect !== styledSelect) {
                                                otherStyledSelect.querySelector('.options-container').style.display = 'none';
                                            }
                                        });

                                        optionsContainer.style.display = (optionsContainer.style.display === 'none' || optionsContainer.style.display === '') ? 'block' : 'none';
                                    });

                                    // Добавляем обработчик события клика по элементу options-container
                                    optionsContainer.addEventListener('click', function (event) {
                                        if (event.target.tagName === 'DIV') {
                                            selectedOption.textContent = event.target.textContent;

                                            var selectedPrice = event.target.textContent.split(' - ')[1].replace(/\s+/g, '');
                                            topElement.textContent = selectedPrice.toLocaleString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

                                            optionsContainer.style.display = 'none';
                                        }
                                    });

                                    // Устанавливаем значение .top при загрузке страницы
                                    var initialSelectedOption = selectedOption.textContent;
                                    if (initialSelectedOption !== "") {
                                        var initialPrice = initialSelectedOption.split(' - ')[1].replace(/\s+/g, '');
                                        topElement.textContent = initialPrice.toLocaleString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                                    }
                                });
                            });

                            function addFavorite(campName) {
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        document.getElementById('heart').innerHTML = xhttp.response;
                                    }
                                };
                                xhttp.open("POST", "server/add_favorite.php", true);
                                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                xhttp.send("campName=" + encodeURIComponent(campName));
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
                            }

                        </script>

                        <!-- запрет на повторную отправку формы при перезагрузке -->
                        <script>
                            if ( window.history.replaceState ) {
                                window.history.replaceState( null, null, window.location.href );
                            }
                        </script>

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