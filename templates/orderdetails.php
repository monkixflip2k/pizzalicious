<?php
if (!isset($_GET['order_id'])) {
    echo "Номер заказа не указан.";
    exit();
}

$order_id = intval($_GET['order_id']);

$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
$order_details = $mysql->query("SELECT oi.order_id, oi.product_id, oi.quantity, oi.price, g.name, g.img_path, 
                                        o.payment_method, o.delivery_method, o.delivery_address, o.phone_number, o.delivery_time
                                FROM order_items oi 
                                JOIN goods g ON oi.product_id = g.id 
                                JOIN orders o ON oi.order_id = o.order_id
                                WHERE oi.order_id = '$order_id'");

$order_status = $mysql->query("SELECT status FROM orders WHERE order_id = '$order_id'")->fetch_assoc()['status'];

if (!$order_details) {
    die("Ошибка выполнения запроса: " . $mysql->error);
}

$mysql->close();
?>

<div class="orderdetails_block">
    <h1>Детали заказа №<?= $order_id ?></h1>
    <div class="order_cards">
        <?php 
        $additional_details = [];
        while($item = $order_details->fetch_assoc()): 
            $additional_details = $item; // Сохраняем последние значения для дополнительных деталей заказа
        ?>
            <div class="order_card">
                <img src="<?= htmlspecialchars($item['img_path']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="order_card_content">
                    <p><b>Название товара:</b> <?= htmlspecialchars($item['name']) ?></p>
                    <p><b>Количество:</b> <?= htmlspecialchars($item['quantity']) ?></p>
                    <p><b>Цена за единицу:</b> <?= htmlspecialchars($item['price']) ?> ₽</p>
                    <p><b>Общая стоимость:</b> <?= htmlspecialchars($item['price'] * $item['quantity']) ?> ₽</p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    
    <!-- Дополнительные детали заказа -->
    <?php if(!empty($additional_details)): ?>
        <h2>Дополнительные детали заказа</h2>
        <p><b>Способ оплаты:</b> <?= htmlspecialchars($additional_details['payment_method']) ?></p>
        <p><b>Способ доставки:</b> <?= htmlspecialchars($additional_details['delivery_method']) ?></p>
        <p><b>Адрес доставки:</b> <?= htmlspecialchars($additional_details['delivery_address']) ?></p>
        <p><b>Номер телефона:</b> <?= htmlspecialchars($additional_details['phone_number']) ?></p>
        <p><b>Время доставки:</b> <?= htmlspecialchars($additional_details['delivery_time']) ?></p>
    <?php endif; ?>

    <h2>Изменить статус заказа</h2>
    <form id="statusForm">
        <input type="hidden" name="order_id" value="<?= $order_id ?>">
        <label for="status">Статус:</label>
        <select name="status" id="status">
            <option value="В работе" <?= $order_status == 'В работе' ? 'selected' : '' ?>>В работе</option>
            <option value="Отправлен" <?= $order_status == 'Отправлен' ? 'selected' : '' ?>>Отправлен</option>
            <option value="Доставлен" <?= $order_status == 'Доставлен' ? 'selected' : '' ?>>Доставлен</option>
        </select>
        <button type="submit">Обновить статус</button>
    </form>

    <a href="./pageView.php?id=order-list.php">Назад к списку заказов</a>
</div>

<script>
document.getElementById('statusForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './templates/phpscripts/updateorderstatus.php', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Статус заказа обновлен успешно!');
        } else {
            alert('Ошибка при обновлении статуса заказа.');
        }
    };

    xhr.send(formData);
});
</script>

<style>
    header {
        position: inherit;
    }

    .orderdetails_block {
        width: 50%;
        margin: 80px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .order_cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .order_card {
        background-color: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .order_card img {
        width: 200px;
    }

    .order_card_content {
        padding: 15px;
    }

    .order_card_content p {
        margin: 5px 0;
    }

    .orderdetails_block h2 {
        margin-top: 20px;
    }

    #statusForm {
        margin-top: 10px;
    }

    #statusForm label {
        margin-right: 10px;
    }

    #statusForm select {
        margin-right: 10px;
    }

    #statusForm button {
        background-color: #B72A23;
        color: #fff;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 4px;
    }

    #statusForm button:hover {
        background-color: #A21F1B;
    }

</style>