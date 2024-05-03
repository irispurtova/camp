<?php 
require 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все лагеря</title>

    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/lagerya.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
    <?php require 'header.php'; ?>

    <div class="lagerya">
        <div class="container">
            <p style="font-size: 12px;">
                <a href="index.php" style="color: #585858;">Главная > </a>Все лагеря
            </p>
            <div class="text">
                <span class="title">Детские лагеря 2024</span>
                <?php
                    $sql = "SELECT COUNT(*) AS TotalRows FROM camps";
                    $res = $connect->query($sql);

                    if ($res->num_rows > 0) {
                        $row = $res->fetch_assoc();?>
                        <span style="font-size: 13px; margin-right: 0px;">Найдено
                    <?= $row["TotalRows"]; ?></span> <?php                        
                    } 
                ?>
                
            </div>
                <div class="camps">
                    <div class="left">
                        <div class="dropdown" id="dropdown1">
                            <div class="title">Страна</div>
                            <div class="selected-value">
                                <?php
                                    if (isset($_POST['country'])&&($_POST['country']!='')) {
                                        echo $_POST['country'];
                                    } else {
                                        echo 'Не выбрано';
                                    }
                                ?>                                
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu1">
                                <?php
                                    $sql = "SELECT DISTINCT country FROM camps";
                                    $result = $connect->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $country = $row["country"]; ?>
                                            <a><?= $country; ?></a> <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="dropdown" id="dropdown2">
                            <div class="title">Регион</div>
                            <div class="selected-value">
                                <?php
                                    if (isset($_POST['region'])&&($_POST['region']!='')) {
                                        echo $_POST['region'];
                                    } else {
                                        echo 'Не выбрано';
                                    }
                                ?>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu2">
                                <?php
                                    $sql = "SELECT DISTINCT region FROM camps";
                                    $result = $connect->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $region = $row["region"]; ?>
                                            <a><?= $region; ?></a> <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="dropdown" id="dropdown3">
                            <div class="title">Город</div>
                            <div class="selected-value">Не выбрано</div>
                            <div class="dropdown-menu" id="dropdown-menu3">
                                <?php
                                    $sql = "SELECT DISTINCT city FROM camps";
                                    $result = $connect->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $city = $row["city"]; ?>
                                            <a><?= $city; ?></a> <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="dropdown" id="dropdown4">
                            <div class="title">Тип</div>
                            <div class="selected-value">
                                <?php
                                    if (isset($_POST['category'])&&($_POST['category']!='')) {
                                        echo $_POST['category'];
                                    } elseif (isset($_POST['category_camp'])&&($_POST['category_camp']!='')) {
                                        echo $_POST['category_camp'];
                                    } else {
                                        echo 'Не выбрано';
                                    }
                                ?>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu4">
                                <?php
                                    $sql = "SELECT * FROM categories";
                                    $result = $connect->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $category = $row["category"]; ?>
                                            <a><?= $category; ?></a> <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="dropdown" id="dropdown5">
                            <div class="title">Сезон</div>
                            <div class="selected-value">
                                <?php
                                    if (isset($_POST['season'])&&($_POST['season']!='')) {
                                        echo $_POST['season'];
                                    } else {
                                        echo 'Не выбрано';
                                    }
                                ?>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu5">
                                <?php
                                    $sql = "SELECT * FROM season";
                                    $result = $connect->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $season = $row["season"]; ?>
                                            <a><?= $season; ?></a> <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="dropdown" id="dropdown6">
                            <div class="title">Возраст</div>
                            <div class="selected-value">Не выбрано</div>
                            <div class="dropdown-menu" id="dropdown-menu6">
                                <a>3 года</a>
                                <a>4 года</a>
                                <a>5 лет</a>
                                <a>6 лет</a>
                                <a>7 лет</a>
                                <a>8 лет</a>
                                <a>9 лет</a>
                                <a>10 лет</a>
                                <a>11 лет</a>
                                <a>12 лет</a>
                                <a>13 лет</a>
                                <a>14 лет</a>
                                <a>15 лет</a>
                                <a>16 лет</a>
                                <a>17 лет</a>
                                <a>18 лет</a>
                            </div>
                        </div>

                        <div class="dropdown" style="height: 135px;">
                            <h4
                                style="font-size: 14px; color: #404040; font-weight: 100; margin-left: 10px; padding-top: 20px;">
                                Цена за
                                смену</h4>
                            <?php
                                $sql = "SELECT ROUND(AVG(price)) AS AveragePrice FROM price";
                                $result = $connect->query($sql);

                                if ($result) {
                                    $row = $result->fetch_assoc(); ?>
                                    <h5
                                style="font-size: 12px; color: #404040; font-weight: 100; opacity: 0.8; margin-left: 10px;">
                                Средняя цена: <?=number_format($row["AveragePrice"], 0, '.', ' ');?></h5> <?php
                                } 
                            ?>                            

                            <div class="wrapper">
                                <div class="container">
                                    <div class="slider-track"></div>
                                    <?php
                                        $sql = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM price";
                                        $result = $connect->query($sql);

                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $min_price = $row["min_price"];
                                            $max_price = $row["max_price"];
                                        }
                                    ?>
                                    <input type="range" min="<?=$min_price;?>" max="<?=$max_price;?>" value="<?=$min_price;?>" id="slider-1" name="minPrice"
                                        oninput="slideOne()">
                                    <input type="range" min="<?=$min_price;?>" max="<?=$max_price;?>" value="<?=$max_price;?>" id="slider-2" name="maxPrice"
                                        oninput="slideTwo()">
                                </div>
                                <div class="values">
                                    <div class="min"
                                        style="width: 100px; height: 40px; border-radius: 5px; border: 1px solid #1950a0;">
                                        <p style="font-size: 10px; color: #1950a0; margin-left: 10px;">Мин. цена</p>
                                        <span id="range1" style="font-size: 12px; margin-left: 10px;">
                                            
                                        </span>
                                    </div>
                                    <div class="max"
                                        style="width: 100px; height: 40px; border-radius: 5px; border: 1px solid #1950a0;">
                                        <p style="font-size: 10px; color: #1950a0; margin-left: 10px;">Макс. цена</p>
                                        <span id="range2" style="font-size: 12px; margin-left: 10px;">
                                            
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="booking" onclick="filter_camps(event)" style="cursor: pointer;">НАЙТИ</div>
                        <div class="booking" onclick="resetSelectedValues(event)" style="cursor: pointer; margin-top: 10px; background-color: #f3f6fb; color: #1950a0; border: 1px solid #1950a0; width: 240px">СБРОСИТЬ</div>

                </div>

            <div class="right">
                <div class="filter-wrap">
                    <p>
                        Сортировка:
                        <a onclick="toggleSort()" class="sortirovka">ЦЕНА ЗА СМЕНУ <img src="images/ar-sort.jpg" alt=""
                                style="vertical-align: sub;"></a>
                        <a onclick="toggleEvSort()" class="sortirovka">РЕЙТИНГ <img src="images/ar-sort.jpg" alt=""
                                style="vertical-align: sub;"></a>
                    </p>
                </div>

                <div id="campsContainer"></div>

                <?php include 'modal_booking.php'; ?>

                <script>
                    let apiUrl = 'server/min_max_price.php';

                    fetch(apiUrl)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById("range1").textContent = data.min;
                            document.getElementById("range2").textContent = data.max;

                            document.getElementById("slider-1").value = data.min;
                            document.getElementById("slider-2").value = data.max;

                            fillColor();
                        })
                        .catch(error => console.error('Error:', error));

                    window.onload = function () {
                        <?php
                            if ((isset($_POST['country'])&&($_POST['country']!=''))
                                || (isset($_POST['region'])&&($_POST['region']!=''))
                                || (isset($_POST['category'])&&($_POST['category']!=''))
                                || (isset($_POST['category_camp'])&&($_POST['category_camp']!=''))
                                || (isset($_POST['season'])&&($_POST['season']!=''))) { ?>

                                    filter_camps(event);

                            <?php }
                            ?>
                        slideOne();
                        slideTwo();
                    }

                    let sliderOne = document.getElementById("slider-1");
                    let sliderTwo = document.getElementById("slider-2");
                    let displayValOne = document.getElementById("range1");
                    let displayValTwo = document.getElementById("range2");
                    let minGap = 0;
                    let sliderTrack = document.querySelector(".slider-track");
                    let sliderMaxValue = document.getElementById("slider-1").max;

                    function slideOne() {
                        if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
                            sliderOne.value = parseInt(sliderTwo.value) - minGap;
                        }
                        displayValOne.textContent = sliderOne.value;
                        fillColor();
                    }

                    function slideTwo() {
                        if (parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap) {
                            sliderTwo.value = parseInt(sliderOne.value) + minGap;
                        }
                        displayValTwo.textContent = sliderTwo.value;
                        fillColor();
                    }

                    function fillColor() {
                        let percent1 = (sliderOne.value - sliderOne.min) / (sliderOne.max - sliderOne.min) * 100;
                        let percent2 = (sliderTwo.value - sliderTwo.min) / (sliderTwo.max - sliderTwo.min) * 100;

                        let track = document.querySelector(".slider-track");

                        track.style.background = '';

                        track.style.background += `linear-gradient(to right, #ff8c00 ${percent1}%, #3264fe ${percent1}%, #3264fe ${percent2}%, #ff8c00 ${percent2}%)`;
                    }

                    function setupDropdown(dropdownId, menuId) {
                        var dropdown = document.getElementById(dropdownId);
                        var menu = document.getElementById(menuId);

                        dropdown.addEventListener('click', function () {
                            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
                        });

                        menu.addEventListener('click', function (event) {
                            var selectedValue = event.target.textContent;
                            dropdown.querySelector('.selected-value').textContent = selectedValue;
                            sendAjaxRequest(selectedValue);
                        });

                        document.addEventListener('click', function (event) {
                            if (!dropdown.contains(event.target)) {
                                menu.style.display = 'none';
                            }
                        });
                    }

                    setupDropdown('dropdown1', 'dropdown-menu1');
                    setupDropdown('dropdown2', 'dropdown-menu2');
                    setupDropdown('dropdown3', 'dropdown-menu3');
                    setupDropdown('dropdown4', 'dropdown-menu4');
                    setupDropdown('dropdown5', 'dropdown-menu5');
                    setupDropdown('dropdown6', 'dropdown-menu6');

                    var sortDirection = 0; 
                    var evSortDirection = 0; 
                    var currentCountry = '';
                    var currentRegion = '';
                    var currentCity = '';
                    var currentTheme = '';
                    var currentSeason = '';
                    var currentAge = 0;
                    var minPrice = document.getElementById("slider-1").value;
                    var maxPrice = document.getElementById("slider-2").value;

                    function toggleSort() {
                        sortDirection = (sortDirection === 1) ? 2 : 1; 
                        evSortDirection = 0; 
                        sendAjaxRequest(sortDirection, evSortDirection, currentCountry, currentRegion, currentCity, currentTheme, currentSeason, currentAge, minPrice, maxPrice);
                    }

                    function toggleEvSort() {
                        evSortDirection = (evSortDirection === 1) ? 2 : 1; 
                        sortDirection = 0; 
                        sendAjaxRequest(sortDirection, evSortDirection, currentCountry, currentRegion, currentCity, currentTheme, currentSeason, currentAge, minPrice, maxPrice);
                    }

                    function filter_camps(event) {
                        var country = document.getElementById('dropdown1').querySelector('.selected-value').textContent.trim();
                        var region = document.getElementById('dropdown2').querySelector('.selected-value').textContent.trim();
                        var city = document.getElementById('dropdown3').querySelector('.selected-value').textContent.trim();
                        var theme = document.getElementById('dropdown4').querySelector('.selected-value').textContent.trim();
                        var season = document.getElementById('dropdown5').querySelector('.selected-value').textContent.trim();
                        var age = document.getElementById('dropdown6').querySelector('.selected-value').textContent.trim();

                        var minPrice = document.getElementById("slider-1").value;
                        var maxPrice = document.getElementById("slider-2").value;

                        currentCountry = country;
                        currentRegion = region;
                        currentCity = city;
                        currentTheme = theme;
                        currentSeason = season;
                        currentAge = age;

                        sendAjaxRequest(sortDirection, evSortDirection, country, region, city, theme, season, age, minPrice, maxPrice);
                    }

                    function sendAjaxRequest(sortDirection, evSortDirection, country, region, city, theme, season, age, minPrice, maxPrice) {
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                console.log(this.responseText);
                                document.getElementById("campsContainer").innerHTML = this.responseText;
                                addEventListeners(); 
                            }
                        };
                        xhttp.open("POST", "server/print_camp.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send("sortDirection=" + encodeURIComponent(sortDirection) + 
                                "&evSortDirection=" + encodeURIComponent(evSortDirection) +
                                "&country=" + encodeURIComponent(country) +
                                "&region=" + encodeURIComponent(region) +
                                "&city=" + encodeURIComponent(city) +
                                "&theme=" + encodeURIComponent(theme) +
                                "&season=" + encodeURIComponent(season) +
                                "&age=" + encodeURIComponent(age) + 
                                "&minPrice=" + encodeURIComponent(minPrice) + 
                                "&maxPrice=" + + encodeURIComponent(maxPrice)); 
                    }

                    function openBookingModal(index, name) {
                        var modal = document.getElementById('myModal');
                        var modalContent = modal.querySelector('#modalContent');

                        var selectedOption = document.getElementById('styled-select' + index).querySelector('.selected-option').textContent;
                        var optionsContainerHTML = document.getElementById('ooo' + index).innerHTML;

                        var styledSelectHTML = '<h2>' + name + '</h2>';
                        styledSelectHTML += '<input type="hidden" name="name_camp" id="name_camp" value="' + name + '">';
                        styledSelectHTML += '<div class="styled-select" id="modalStyledSelect" style="width: 298px; background: white; cursor: auto">';        
                        styledSelectHTML += '<div class="title">Выбранный сезон:</div>';
                        styledSelectHTML += '<div class="selected-option">' + selectedOption + '</div>';
                        styledSelectHTML += '<div class="options-container">' + optionsContainerHTML + '</div>';
                        styledSelectHTML += '</div>';

                        modalContent.innerHTML = styledSelectHTML;

                        modal.style.display = 'block';
                    }

                    function closeBookingModal() {
                        var modal = document.getElementById('myModal');
                        modal.style.display = 'none';
                    }

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

                        var price = selectedOption.split(' - ')[1].replace(/\s+/g, '').replace(/[^\d.]/g, '');

                        var xhr = new XMLHttpRequest();

                        xhr.open('POST', 'server/add_booking.php', true);

                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        xhr.send('tel=' + encodeURIComponent(tel) + 
                        '&email=' + encodeURIComponent(email) + 
                        '&nameParent=' + encodeURIComponent(nameParent) + 
                        '&nameChild=' + encodeURIComponent(nameChild) +
                        '&childAge=' + encodeURIComponent(childAge) +
                        '&season=' + encodeURIComponent(season) + 
                        '&price=' + encodeURIComponent(price) +
                        '&name_camp=' + encodeURIComponent(name_camp));

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {                                   
                                alert(xhr.responseText);
                                resetModalBooking();
                            } else if (xhr.readyState === 4 && xhr.status !== 200) {
                                console.error('Ошибка при выполнении запроса');
                            }
                        };
                    }

                    function resetModalBooking() {
                        document.getElementById('tel').value = '';
                        document.getElementById('email').value = '';
                        document.getElementById('nameParent').value = '';
                        document.getElementById('nameChild').value = '';
                        document.getElementById('childAge').value = '';
                    }

                    function addEventListeners() {
                        var styledSelects = document.querySelectorAll('.styled-select');

                        styledSelects.forEach(function (styledSelect) {
                            var optionsContainer = styledSelect.querySelector('.options-container');
                            var selectedOption = styledSelect.querySelector('.selected-option');
                            var topElement = styledSelect.nextElementSibling.querySelector('.top');

                            styledSelect.addEventListener('click', function () {
                                styledSelects.forEach(function (otherStyledSelect) {
                                    if (otherStyledSelect !== styledSelect) {
                                        otherStyledSelect.querySelector('.options-container').style.display = 'none';
                                    }
                                });

                                optionsContainer.style.display = (optionsContainer.style.display === 'none' || optionsContainer.style.display === '') ? 'block' : 'none';
                            });

                            optionsContainer.addEventListener('click', function (event) {
                                if (event.target.tagName === 'DIV') {
                                    selectedOption.textContent = event.target.textContent;

                                    var selectedPrice = event.target.textContent.split(' - ')[1].replace(/\s+/g, '');
                                    topElement.textContent = selectedPrice.toLocaleString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

                                    optionsContainer.style.display = 'none';
                                }
                            });

                            var initialSelectedOption = selectedOption.textContent;
                            if (initialSelectedOption !== "") {
                                var initialPrice = initialSelectedOption.split(' - ')[1].replace(/\s+/g, '');
                                topElement.textContent = initialPrice.toLocaleString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                            }
                        });
                    }

                    if ( window.history.replaceState ) {
                        window.history.replaceState( null, null, window.location.href );
                    }

                    document.addEventListener('DOMContentLoaded', function () {
                        sendAjaxRequest(sortDirection, evSortDirection, currentCountry, currentRegion, currentCity, currentTheme, currentSeason, currentAge, minPrice, maxPrice);
                    });

                    function resetSelectedValues(event) {
                        event.preventDefault();
                        var selectedValues = document.querySelectorAll('.selected-value');

                        selectedValues.forEach(function(selectedValue) {
                            selectedValue.textContent = 'Не выбрано';
                        });

                        let apiUrl = 'server/min_max_price.php';

                    fetch(apiUrl)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById("range1").textContent = data.min;
                            document.getElementById("range2").textContent = data.max;

                            document.getElementById("slider-1").value = data.min;
                            document.getElementById("slider-2").value = data.max;

                            fillColor();
                        })
                        .catch(error => console.error('Error:', error));

                        sendAjaxRequest(sortDirection, evSortDirection, '', '', '', '', '', '');
                    }
                    
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

                        sendAjaxRequest(sortDirection, evSortDirection, currentCountry, currentRegion, currentCity, currentTheme, currentSeason, currentAge, minPrice, maxPrice);
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

                        sendAjaxRequest(sortDirection, evSortDirection, currentCountry, currentRegion, currentCity, currentTheme, currentSeason, currentAge, minPrice, maxPrice);
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