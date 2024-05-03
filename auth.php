<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Окно авторизации</title>

    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/auth.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>

<body>
    <?php require 'header.php'; ?>

    <div class="auth">
        <div class="container">
            <div class="auth-container">
                <div class="auth-tab">
                    <button class="tab-btn active" data-tab="login">Вход</button>
                </div>
                <div class="auth-content">
                    <form id="login-form" class="form-group">
                        <label for="login-username">Имя пользователя:</label>
                        <input type="text" id="login-username" name="login" placeholder="Введите имя пользователя">
                        <label for="login-password">Пароль:</label>
                        <input type="password" id="login-password" name="password" placeholder="Введите пароль">
                        <button onclick="loginAccount(event)">ВОЙТИ</button>
                    </form>
                </div>
            </div>
            <script>
                function loginAccount(event) {
                    event.preventDefault();

                    let form = document.getElementById('login-form');
                    let formData = new FormData(form);
                    var url = 'auth/log.php';
                    let xhr = new XMLHttpRequest();

                    xhr.open('POST', url, true);

                    xhr.send(formData);
                    xhr.onload = () => {
                        if (xhr.response === 'admin') {
                            window.location.replace("admin/main.php");
                        } else if (xhr.response === 'user') {
                            window.location.replace("index.php");
                        } else {
                            alert(xhr.response);
                        }
                    }
                }
            </script>

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