<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

    $stmt = $mysql->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param('si', $status, $order_id);

    if ($stmt->execute()) {
        echo "Статус заказа успешно обновлен.";
    } else {
        echo "Ошибка при обновлении статуса заказа.";
    }

    $stmt->close();
    $mysql->close();
}

?>