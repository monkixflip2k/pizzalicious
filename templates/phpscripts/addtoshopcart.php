<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

$item_id = $_GET['item_id'];
$status = $_GET['status'];
$user_id = $_GET['user_id'];
$quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

if ($status == 'add') {
    // Проверяем, существует ли уже запись с данным товаром в корзине
    $stmt = $mysql->prepare("SELECT `quantity` FROM `shopping_cart` WHERE `user_id` = ? AND `product_id` = ?");
    $stmt->bind_param('ii', $user_id, $item_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Если запись существует, обновляем количество
        $stmt->bind_result($existing_quantity);
        $stmt->fetch();
        $new_quantity = $existing_quantity + $quantity;
        $update_stmt = $mysql->prepare("UPDATE `shopping_cart` SET `quantity` = ? WHERE `user_id` = ? AND `product_id` = ?");
        $update_stmt->bind_param('iii', $new_quantity, $user_id, $item_id);
        $update_stmt->execute();
        $update_stmt->close();
        echo "Количество товара обновлено в корзине";
    } else {
        // Если записи нет, вставляем новую
        $insert_stmt = $mysql->prepare("INSERT INTO `shopping_cart` (`user_id`, `product_id`, `quantity`) VALUES (?, ?, ?)");
        $insert_stmt->bind_param('iii', $user_id, $item_id, $quantity);
        $insert_stmt->execute();
        $insert_stmt->close();
        echo "Товар добавлен в корзину";
    }

    $stmt->close();
} elseif ($status == 'del') {
    $stmt = $mysql->prepare("DELETE FROM `shopping_cart` WHERE `user_id` = ? AND `product_id` = ?");
    $stmt->bind_param('ii', $user_id, $item_id);
    $stmt->execute();
    echo "Товар удален из корзины";
    $stmt->close();
}

$mysql->close();
?>