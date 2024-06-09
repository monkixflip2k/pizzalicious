<?php
if (!isset($_COOKIE['user'])) {
    header('Location: auth.php');
    exit();
}

$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

$user = $mysql->real_escape_string($_COOKIE['user']);
$user_result = $mysql->query("SELECT `id` FROM `users` WHERE `username` = '$user'");
if (!$user_result) {
    die("Ошибка выполнения запроса: " . $mysql->error);
}
$user_row = $user_result->fetch_assoc();
$user_id = $user_row['id'];

$payment_method = $_POST['payment_method'];
$delivery_method = $_POST['delivery_method'];
$delivery_address = $delivery_method == 'courier' ? $_POST['delivery_address'] : NULL;
$phone_number = $_POST['phone_number'];
$delivery_time = $_POST['delivery_time'];

$current_time = new DateTime();
$delivery_hour = intval(substr($delivery_time, 0, 2));
$delivery_minute = intval(substr($delivery_time, 3, 2));
$current_hour = intval($current_time->format('H'));
$current_minute = intval($current_time->format('i'));

$current_date = date('Y-m-d');
$delivery_datetime = $current_date . ' ' . $delivery_time . ':00';

$cart_results = $mysql->query("SELECT sc.product_id, sc.quantity, g.price 
                               FROM `shopping_cart` sc 
                               JOIN `goods` g ON sc.product_id = g.id 
                               WHERE sc.user_id = '$user_id'");
if (!$cart_results) {
    die("Ошибка выполнения запроса: " . $mysql->error);
}

$total_price = 0;
$items = [];
while ($row = $cart_results->fetch_assoc()) {
    $items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
}

if (empty($items)) {
    echo "Ваша корзина пуста.";
    exit();
}


$prize_result = $mysql->query("SELECT * FROM `user_prizes` WHERE `user_id` = '$user_id' LIMIT 1");
$prize = $prize_result->fetch_assoc();
$applied_prize = null;


$activate_prize = isset($_POST['activate_prize']) && $_POST['activate_prize'] == 'on';

if ($prize && $activate_prize) {
    //echo "Приз найден: {$prize['prize']}<br>";

    if ($total_price >= 1000) {
        if (strpos($prize['prize'], '%') !== false) {
            preg_match('/(\d+)%/', $prize['prize'], $matches);
            $discount = $matches[1] / 100;
            $total_price -= $total_price * $discount;
            $applied_prize = $prize['prize'];
            //echo "Приз скидки применен: $applied_prize<br>";
        } elseif ($prize['prize'] == 'Пепперони!') {
            $applied_prize = $prize['prize'];
            //echo "Приз бесплатной пиццы применен: $applied_prize<br>";
            
            
            $pepperoni_id_result = $mysql->query("SELECT `id` FROM `goods` WHERE `name` = 'Пепперони'");
            $pepperoni_id = $pepperoni_id_result->fetch_assoc()['id'];
            if ($pepperoni_id) {
                $items[] = [
                    'product_id' => $pepperoni_id,
                    'quantity' => 1,
                    'price' => 0
                ];
                //echo "Бесплатная пицца Пепперони добавлена в заказ с ID: $pepperoni_id<br>";
            } else {
                //echo "Ошибка: Пицца Пепперони не найдена в таблице товаров.<br>";
            }
        }

        
        $mysql->query("DELETE FROM `user_prizes` WHERE `id` = '{$prize['id']}'");
        //echo "Приз удален из базы данных<br>";
    } else {
        //echo "Сумма заказа меньше 1000 рублей, приз не может быть активирован.<br>";
    }
}


$mysql->query("INSERT INTO `orders` (`user_id`, `total_price`, `payment_method`, `delivery_method`, `delivery_address`, `phone_number`, `delivery_time`, `applied_prize`) 
               VALUES ('$user_id', '$total_price', '$payment_method', '$delivery_method', '$delivery_address', '$phone_number', '$delivery_datetime', '$applied_prize')");
$order_id = $mysql->insert_id;
echo "Заказ создан с ID: $order_id<br>";

foreach ($items as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $price = $item['price'];
    $mysql->query("INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`) 
                   VALUES ('$order_id', '$product_id', '$quantity', '$price')");
    echo "Добавлен элемент заказа: продукт ID $product_id, количество $quantity, цена $price<br>";
}

$mysql->query("DELETE FROM `shopping_cart` WHERE `user_id` = '$user_id'");
echo "Корзина очищена для пользователя ID: $user_id<br>";

$mysql->close();
?>

<div class="checkout_block">
    <h1>Заказ успешно оформлен!</h1>
    <p>Ваш заказ номер <?= $order_id ?> был успешно оформлен.</p>
    <?php if ($applied_prize): ?>
        <p>Ваш заказ оформлен с использованием приза: <?= $applied_prize ?></p>
    <?php else: ?>
        <p>Ваш заказ оформлен, призов нет.</p>
    <?php endif; ?>
    <a href="index.php">Вернуться на главную</a>
</div>