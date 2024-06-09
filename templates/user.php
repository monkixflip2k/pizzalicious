<div class="user_block" id="user-block" style="display: none;">
    <div class="user">
        <a href="./index.php">Главная</a>
        <?php if ($_COOKIE['user'] == 'admin'): ?>
            <a href="./pageView.php?id=addproduct.php">Добавить товар</a>
            <a href="./pageView.php?id=user-list.php">Список пользователей</a>
            <a href="./pageView.php?id=order-list.php">Просмотр заказов</a>
        <?php endif; ?>
        <a href="./templates/phpscripts/exit.php">Выйти</a>
    </div>
</div>