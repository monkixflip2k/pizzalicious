<?php
// Подключение к базе данных
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

// Проверка подключения
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

// Проверка наличия ID товара
if (!isset($item['id'])) {
    die("Ошибка: ID товара не установлен.");
}

// Получение ингредиентов для товара
$product_id = $item['id'];
$query = "SELECT ingredients.name 
          FROM ingredients 
          JOIN product_ingredients ON ingredients.id = product_ingredients.ingredient_id 
          WHERE product_ingredients.product_id = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$ingredients = [];
while ($row = $result->fetch_assoc()) {
    $ingredients[] = $row['name'];
}
$ingredients_list = implode(', ', $ingredients);

// Закрытие соединения с базой данных
$stmt->close();
$mysql->close();
?>
<a href="#" class="desc_link" style="text-decoration: none; color:#000000;" data-id="<?=$item['id'];?>">
<div class="sectionFive__block--center--blockTwo__col--desc">
    <p style="font-weight: bold; font-size:24px;">
        <?=$item['name']; ?>
    </p>
    <p style="text-align: end; font-weight: bold; font-size:24px;">
        <?=$item['price']; ?>₽
    </p>
    <p class="sectionFive__block--center--blockTwo__col--desc--text">
        <?= htmlspecialchars($ingredients_list); ?>
    </p>
</div>
</a>