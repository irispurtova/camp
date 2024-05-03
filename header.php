<?php
    session_start();
?>
<div class="camp-header">
    <div class="logo"><a href="index.php"><img src="images/logo-white.jpeg" alt="logo" width="49px"></a></div>
    <ul class="main-menu">
        <li>
            <a href="lagerya.php?">ВСЕ ЛАГЕРЯ</a>
        </li>
        <li>
            <a href="about-us.php">О НАС</a>
        </li>
        <li>
            <a href="feedback.php">ОТЗЫВЫ</a>
        </li>
        <?php
        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') {
            echo '<li> <a href="favorite.php">ИЗБРАННОЕ</a> </li>';               
        }
    ?>
    </ul>
    <?php
        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') {
            echo '<div class="hello_user"> привет, пользователь! </div>';
            echo '<div class="bye_user"> <a href="auth/unlog.php">Выйти</a> </div>';                
        }
    ?>
    <div class="icons">
        <div class="icon"><a href="#"><img src="images/wp-icon.svg" alt="wp"></a></div>
        <div class="icon"><a href="#"><img src="images/tg-icon.svg" alt="tg"></a></div>
        <?php
        if (!isset($_SESSION['auth'])) {
            echo '<div class="icon"><a href="auth.php"><img src="images/user-icon.svg" alt="user"></a></div>';             
        }
    ?>
    </div>
</div>