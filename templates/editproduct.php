<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
$product_id = intval($_GET['product_id']);
$product = $mysql->query("SELECT * FROM `goods` WHERE `id` = '$product_id'")->fetch_assoc();
$ingredients = $mysql->query("SELECT * FROM `ingredients`")->fetch_all(MYSQLI_ASSOC);
$selected_ingredients = $mysql->query("SELECT `ingredient_id` FROM `product_ingredients` WHERE `product_id` = '$product_id'")->fetch_all(MYSQLI_ASSOC);

$selected_ingredients_ids = array_column($selected_ingredients, 'ingredient_id');

$mysql->close();
?>

<form class="addedproduct_form" action="./templates/phpscripts/editproduct.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
    <label>Название</label>
    <input type="text" name="product_name" placeholder="Введите название товара" value="<?= htmlspecialchars($product['name']) ?>" required>
    <label>Тип товара</label>
    <input type="text" name="product_type" placeholder="Введите тип товара" value="<?= htmlspecialchars($product['type']) ?>" required>
    <label>Описание</label>
    <textarea name="product_description" cols="35" rows="10" placeholder="Введите описание товара"><?= htmlspecialchars($product['description']) ?></textarea>
    <label>Ингредиенты</label>
    <?php foreach($ingredients as $ingredient): ?>
        <label>
            <input type="checkbox" name="product_ingredients[]" value="<?= $ingredient['id'] ?>" 
                <?= in_array($ingredient['id'], $selected_ingredients_ids) ? 'checked' : '' ?>>
            <?= htmlspecialchars($ingredient['name']) ?>
        </label>
    <?php endforeach; ?>
    <label>Цена</label>
    <input type="number" name="product_price" placeholder="Введите цену товара" value="<?= $product['price'] ?>" required>
    <label>Картинка</label>
    <input type="file" name="product_img">
    <input type="submit" value="Сохранить изменения" name="edit_product">
</form>

<style>
    header {
        position: inherit;
    }
</style>