<?php
// Подключение к базе данных
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

// Получение списка ингредиентов
$result = $mysql->query("SELECT id, name FROM ingredients");
$ingredients = [];
while ($row = $result->fetch_assoc()) {
    $ingredients[] = $row;
}

// Закрытие соединения с базой данных
$mysql->close();
?>

<div class="addedproduct_block">
    <div class="addedproduct_block_content">
        <p>Добавление товара</p>
        <form class="addedproduct_form" action="./templates/phpscripts/addproduct.php" method="post" enctype="multipart/form-data">
            <label>Название</label>
            <input type="text" name="product_name" placeholder="Введите название товара" required>
            <label>Тип товара</label>
            <input type="text" name="product_type" placeholder="Введите тип товара" required>
            <label>Описание</label>
            <textarea name="product_description" cols="35" rows="10" placeholder="Введите описание товара"></textarea>
            <label>Ингредиенты</label>
            <?php foreach ($ingredients as $ingredient): ?>
                <label>
                    <input type="checkbox" name="product_ingredients[]" value="<?= $ingredient['id'] ?>">
                    <?= htmlspecialchars($ingredient['name']) ?>
                </label>
            <?php endforeach; ?>
            <label>Цена</label>
            <input type="number" name="product_price" placeholder="Введите цену товара" required>
            <label>Картинка</label>
            <input type="file" name="product_img" required>
            <input type="submit" value="Добавить товар" name="add_product">
        </form>
        <?php if (isset($_COOKIE['error'])): ?>
            <p><?= htmlspecialchars($_COOKIE['error']) ?></p>
        <?php endif; ?>
    </div>
</div>

<style>
    header {
        position: inherit;
    }
</style>