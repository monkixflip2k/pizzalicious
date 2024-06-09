<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

// Проверяем подключение
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

// Получаем ID текущего пользователя из куки
$user = isset($_COOKIE['user']) ? $_COOKIE['user'] : null;

$count = 0;
if ($user) {
    // Получаем ID пользователя по его имени
    $userResult = $mysql->query("SELECT `id` FROM `users` WHERE `username` = '$user'");
    if ($userResult && $userResult->num_rows > 0) {
        $user_id = $userResult->fetch_assoc()['id'];

        // Получаем количество товаров в корзине для текущего пользователя
        $countResult = $mysql->query("SELECT COUNT(*) AS count FROM `shopping_cart` WHERE `user_id` = '$user_id'");
        if ($countResult) {
            $count = $countResult->fetch_assoc()['count'];
        }
    }
}

$mysql->close();
?>

<div class="route">
    <div class="route__one">
        <a href="./index.php">Главная</a>
        <a href="./index.php">О нас</a>
        <a href="menu.php">Меню</a>
        <a href="#contacts">Контакты</a>
    </div>
    <div class="route__two">
        <img style="max-width: 324px; width: 100%;" src="img/Pizzalicious.png" alt="">
    </div>
    <div class="route__three">
        <?php if(!isset($_COOKIE['user'])): ?>
            <a href="./pageView.php?id=auth.php" id="loginLink">Вход</a>
            <a href="./pageView.php?id=registration.php" id="registerLink">Регистрация</a>
        <?php else: ?>
            <div>
            <a href="#" id="user-link"><?=$_COOKIE['user']?></a>
            <div id="user-block-container"></div>
            </div>
        <?php endif; ?>
        <?php if(isset($_COOKIE['user'])): ?>
            <a href="./pageView.php?id=shoppingcart.php">Корзина (<?= $count ?>)</a>
        <?php else: ?>
            <a href="./pageView.php?id=auth.php">Корзина (<?= $count ?>)</a>
        <?php endif; ?>
    </div>
    <div class="burger-menu" id="burgerMenu">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<nav class="mobile-nav" id="mobileNav">
    <a href="./index.php">Главная</a>
    <a href="./index.php">О нас</a>
    <a href="./index.php">Меню</a>
    <a href="./index.php">Контакты</a>
    <?php if(!isset($_COOKIE['user'])): ?>
        <a href="./pageView.php?id=auth.php" id="loginLink">Вход</a>
        <a href="./pageView.php?id=registration.php" id="registerLink">Регистрация</a>
    <?php else: ?>
        <a href="#" id="user-link"><?=$_COOKIE['user']?></a>
        <div id="user-block-container"></div>
    <?php endif; ?>
    <?php if(isset($_COOKIE['user'])): ?>
        <a href="./pageView.php?id=shoppingcart.php">Корзина (<?= $count ?>)</a>
    <?php else: ?>
        <a href="./pageView.php?id=auth.php">Корзина (<?= $count ?>)</a>
    <?php endif; ?>
</nav>