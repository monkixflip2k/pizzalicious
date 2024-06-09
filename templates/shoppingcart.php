<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
$user = $_COOKIE['user'];
$result = $mysql->query("SELECT `id` FROM `users` WHERE `username` = '$user'")->fetch_assoc();
$user_id = $result['id'];

// Получение товаров в корзине
$cart_items = $mysql->query("SELECT * FROM `shopping_cart` WHERE `user_id` = '$user_id'");

// Получение заказов пользователя и их товаров
$orders = $mysql->query("
    SELECT orders.order_id, orders.total_price, orders.status, orders.payment_method, orders.delivery_method, orders.delivery_address, orders.phone_number, orders.delivery_time, order_items.product_id, order_items.quantity, order_items.price, goods.name AS product_name, goods.img_path AS product_img
    FROM orders
    JOIN order_items ON orders.order_id = order_items.order_id
    JOIN goods ON order_items.product_id = goods.id
    WHERE orders.user_id = '$user_id'
    ORDER BY orders.order_id DESC
");

$order_details = [];
if ($orders->num_rows > 0) {
    while ($row = $orders->fetch_assoc()) {
        $order_id = $row['order_id'];
        if (!isset($order_details[$order_id])) {
            $order_details[$order_id] = [
                'total_price' => $row['total_price'],
                'status' => $row['status'],
                'payment_method' => $row['payment_method'],
                'delivery_method' => $row['delivery_method'],
                'delivery_address' => $row['delivery_address'],
                'phone_number' => $row['phone_number'],
                'delivery_time' => $row['delivery_time'],
                'items' => []
            ];
        }
        $order_details[$order_id]['items'][] = [
            'product_name' => $row['product_name'],
            'product_img' => $row['product_img'],
            'quantity' => $row['quantity'],
            'price' => $row['price']
        ];
    }
}

// Получение текущего приза пользователя
$current_prize = $mysql->query("
    SELECT prize, expiration 
    FROM user_prizes 
    WHERE user_id = '$user_id' AND expiration > NOW()
")->fetch_assoc();

$mysql->close();
?>

<div class="shopping_cart">
    <?php if($cart_items != NULL && $cart_items->num_rows > 0): ?>
        <?php foreach($cart_items as $item): ?>
            <?= renderTemplate('templates/shoppingcartitem.php', ['item' => $item]); ?>
        <?php endforeach; ?>
        <form action="./pageView.php?id=checkout.php" method="post">
            <button type="submit">Оформить заказ</button>
        </form>
    <?php else: ?>
        <p>Корзина пуста</p>
        <form>
            <button type="submit" disabled>Оформить заказ</button>
        </form>
    <?php endif; ?>

    <h2>Ваши заказы</h2>
    <?php if (!empty($order_details)): ?>
        <?php foreach ($order_details as $order_id => $order): ?>
            <div class="order">
                <h3>Заказ № <?= $order_id ?></h3>
                <p>Статус: <?= $order['status'] ?></p>
                <p>Общая сумма: <?= $order['total_price'] ?>₽</p>
                <p>Способ оплаты: <?= $order['payment_method'] ?></p>
                <p>Способ доставки: <?= $order['delivery_method'] ?></p>
                <p>Адрес доставки: <?= $order['delivery_address'] ?></p>
                <p>Телефон: <?= $order['phone_number'] ?></p>
                <p>Время доставки: <?= $order['delivery_time'] ?></p>
                <div class="order-items">
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="order-item">
                            <img src="<?=$item['product_img']?>" alt="<?=$item['product_name']?>" class="order-item-img">
                            <div class="order-item-details">
                                <p>Товар: <?=$item['product_name']?></p>
                                <p>Количество: <?=$item['quantity']?></p>
                                <p>Цена: <?=$item['price']?>₽</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>У вас нет заказов</p>
    <?php endif; ?>

    <h2>Ваши призы</h2>
    <?php if ($current_prize): ?>
        <div class="prize">
            <p>Приз: <?=$current_prize['prize']?></p>
            <p>Действителен до: <?=$current_prize['expiration']?></p>
        </div>
    <?php else: ?>
        <p>У вас нет активных призов</p>
    <?php endif; ?>
</div>

<style>
    main {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    header {
        position: inherit;
    }
    .shopping_cart {
        width: 90%;
        margin: 80px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .order {
        background-color: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
    .order-items {
        margin-top: 10px;
    }
    .order-item {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 5px 0;
        display: flex;
        align-items: center;
    }
    .order-item-img {
        width: 200px;
    }
    .order-item-details {
        display: flex;
        flex-direction: column;
    }
    .prize {
        background-color: #e9ffe9;
        border: 1px solid #cce5cc;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }
</style>