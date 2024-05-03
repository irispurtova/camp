<?php require 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>

    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/about-us.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
    <?php require 'header.php'; ?>

    <div class="about-us">
        <div class="container">
            <div class="bread-crumbs">
                <p style="font-size: 12px;">
                    <a href="index.php" style="color: #585858;">Главная > </a>О нас
                </p>
            </div>

            <h1>Сервис по поиску и <br> бронированию лагеря в России и зарубежом</h1>
            <p>В нашей базе уже 
                <?php
                    $sql = "SELECT COUNT(*) AS TotalRows FROM camps";
                    $res = $connect->query($sql);

                    if ($res->num_rows > 0) {
                        $row = $res->fetch_assoc();
                        echo $row["TotalRows"];                        
                    } ?> лагерей</p>

            <ul class="info-list">
                <li>
                    <div class="top"><img src="images/correct-icon.svg" alt="" style="margin: 0px;"><span
                            style="margin-left: 10px;">Самая большая база</span></div>
                    <p>На портале Kidsincamp размещены наиболее популярные детские лагеря России с самыми разнообразными
                        направлениями и тематиками смен.</p>
                </li>
                <li>
                    <div class="top"><img src="images/correct-icon.svg" alt="" style="margin: 0px;"><span
                            style="margin-left: 10px;">Бронирование без оплаты</span></div>
                    <p>Мы удерживаем комиссию только за приобретенные через наш сайт путевки. Размер комиссии
                        определяется договором. Сервис оставляет за собой право предоставлять скидку на путевки за счет
                        своей комиссии.</p>
                </li>
                <li>
                    <div class="top"><img src="images/correct-icon.svg" alt="" style="margin: 0px;"><span
                            style="margin-left: 10px;">Честные отзывы</span></div>
                    <p>Отзывы реальных участников смен и их родителей помогут лучше познакомиться с программой и
                        условиями проживания в лагере.</p>
                </li>
                <li>
                    <div class="top"><img src="images/correct-icon.svg" alt="" style="margin: 0px;"><span
                            style="margin-left: 10px;">Система рейтинга</span></div>
                    <p>Организуйте для ребенка такую поездку, которую он обязательно захочет повторить!</p>
                </li>
                <li>
                    <div class="top"><img src="images/correct-icon.svg" alt="" style="margin: 0px;"><span
                            style="margin-left: 10px;">Мы профессионалы</span></div>
                    <p>Имея большой опыт в сфере организации детского отдыха, мы внимательно подходим к отбору и подаче
                        информации на портале, давая только актуальные и самые интересные сведения о каждом лагере.</p>
                </li>
                <li>
                    <div class="top"><img src="images/correct-icon.svg" alt="" style="margin: 0px;"><span
                            style="margin-left: 10px;">Поддержка 24/7</span></div>
                    <p>Сотрудники портала всегда готовы решить все вопросы, важные для организации детского отдыха высокого класса</p>
                </li>
            </ul>

            <div class="poisk-block">
                <h2>Начните поиск лагеря прямо сейчас!</h2>

                <a href="lagerya.php">
                    <div class="button">ПОДОБРАТЬ ЛАГЕРЬ</div>
                </a>
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