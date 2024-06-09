<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

// Проверка подключения
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

// Обновление количества товаров, если запрос пришел через AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity']) && isset($_POST['product_id']) && isset($_POST['user_id'])) {
    $quantity = intval($_POST['quantity']);
    $product_id = intval($_POST['product_id']);
    $user_id = intval($_POST['user_id']);

    if ($quantity > 0) {
        $stmt = $mysql->prepare("UPDATE `shopping_cart` SET `quantity` = ? WHERE `product_id` = ? AND `user_id` = ?");
        $stmt->bind_param("iii", $quantity, $product_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    exit();
}

// Получение данных для отображения товаров в корзине
$product_id = $item['product_id'];
$user_id = $item['user_id'];
$result = $mysql->query("SELECT * FROM `goods` WHERE `id` = '$product_id'")->fetch_assoc();

$mysql->close();
?>

<div class="cart-card">
    <img class="pizza" src="<?=$result['img_path']?>" alt="">
    <p><?=$result['name'];?></p>
    <p><?=$result['price'];?> ₽</p>
    <input type="number" value="<?=$item['quantity']?>" onchange="updateQuantity(this.value, <?=$product_id?>, <?=$user_id?>)">
    <a href="./templates/phpscripts/deletefromcart.php?product_id=<?=$product_id?>&user_id=<?=$user_id?>">Удалить</a>
</div>