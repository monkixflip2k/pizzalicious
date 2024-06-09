<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
$results = $mysql->query("SELECT o.order_id, o.total_price, o.status, u.username, o.delivery_time
                          FROM orders o 
                          JOIN users u ON o.user_id = u.id 
                          ORDER BY o.delivery_time ASC
                          ");
$mysql->close();
?>

<div class="orderlist_block">
    <h1>Список заказов</h1>
    <table>
        <tr>
            <th>Номер заказа</th>
            <th>Пользователь</th>
            <th>Общая сумма</th>
            <th>Статус</th>
            <th>Время доставки</th>
        </tr>
        <?php while($order = $results->fetch_assoc()): ?>
            <tr>
                <td><a href="./pageView.php?id=orderdetails.php&order_id=<?= $order['order_id'] ?>"><?= $order['order_id'] ?></a></td>
                <td><?= $order['username'] ?></td>
                <td><?= $order['total_price'] ?> ₽</td>
                <td><?= $order['status'] ?></td>
                <td><?= $order['delivery_time'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<style>
    header {
        position: inherit;
    }
</style>