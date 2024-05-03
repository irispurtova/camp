<?php
    require 'connect.php';
    $userid = mysqli_real_escape_string($connect, $_GET["id"]);

    $sql = "SELECT * FROM camps WHERE camps.id = $userid";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $name = $row["name"];  
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лучшие детские лагеря</title>

    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/add-feedback.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <div class="add-feedback">
        <div class="container">
            <p class="bread-crumbs" style="font-size: 12px; padding-bottom: 20px">
                <a href="index.php" style="color: #585858;">Главная > </a> <a href="feedback.php" style="color: #585858;">Отзывы о лагерях > </a> Добавить отзыв
            </p>

            <form method="POST">
                <div class="container-block">
                    <h1>Добавить отзыв лагерю <?=$name;?></h1>

                    <div class="block-top">
                        <div class="name">
                            <label for="fio" style="margin-left: 0px">Имя</label>
                            <input type="text" name="name" placeholder="Укажите ваше ФИО" id="fio" required>
                        </div>
                        <div class="email">
                            <label for="email" style="margin-left: 40px">Электронная почта</label>
                            <input type="email" name="email" placeholder="Укажите ваш адрес электронной почты" id="email" required>
                        </div>                    
                    </div>

                    <div class="block-center">
                        <label for="otzyv" style="margin-left: 0px">Ваш отзыв</label>
                        <textarea id="otzyv" cols="30" rows="10" placeholder="Напишите ваши впечатления о лагере" name="text_user" required></textarea>
                    </div>

                    <div class="review-rating-label">Рейтинг</div>

                    <div class="module-rating-stars">
                        <input type="radio" class="check" name="stars" id="one" value="1">
                        <input type="radio" class="check" name="stars" id="two" value="2">
                        <input type="radio" class="check" name="stars" id="three" value="3">
                        <input type="radio" class="check" name="stars" id="four" value="4">
                        <input type="radio" class="check" name="stars" id="five" value="5">
                        <label for="one" class="stars"></label>
                        <label for="two" class="stars"></label>
                        <label for="three" class="stars"></label>
                        <label for="four" class="stars"></label>
                        <label for="five" class="stars"></label>
                    </div>

                    <input type="submit" id="create-review" value="Опубликовать">
                </div>
            </form>

            <?php   
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name_user = htmlentities(mysqli_real_escape_string($connect, $_POST['name']));
                    $email_user = htmlentities(mysqli_real_escape_string($connect, $_POST['email']));;
                    $text_user = htmlentities(mysqli_real_escape_string($connect, $_POST['text_user']));;

                    if(isset($_POST['stars'])) {
                        if ($_POST['stars'] == '1') {
                            $evaluation = 1;
                        } elseif ($_POST['stars'] == '2') {
                            $evaluation = 2;
                        } elseif ($_POST['stars'] == '3') {
                            $evaluation = 3;
                        } elseif ($_POST['stars'] == '4') {
                            $evaluation = 4;
                        } elseif ($_POST['stars'] == '5') {
                            $evaluation = 5;
                        }
                    }
                    
                    $sql = "INSERT INTO feedback (user, email, name, text, evaluation, up, down) VALUES ('$name_user', '$email_user', '$name','$text_user', '$evaluation', 0, 0)";

                    if (mysqli_query($connect, $sql)) {
                        echo '<div class="result" style="padding-top: 20px">Спасибо за отзыв!</div>';
                    } else {
                        echo 'Error adding booking: ' . mysqli_error($connect);
                    }
                }?>
        </div>

        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
        
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