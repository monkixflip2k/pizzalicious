<?php
if (!isset($_COOKIE['user'])) {
    header('Location: auth.php'); // Перенаправление на страницу авторизации, если пользователь не авторизован
    exit();
}

$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

$user = $_COOKIE['user'];
$user_result = $mysql->query("SELECT `id` FROM `users` WHERE `username` = '$user'")->fetch_assoc();
$user_id = $user_result['id'];

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

$mysql->close();
?>

<div class="checkout_block">
<form action="./pageView.php?id=checkout_process.php" method="post">
    <h2>Оформление заказа</h2>
    
    <label for="delivery_method">Способ получения заказа:</label><br>
    <input type="radio" id="delivery_pickup" name="delivery_method" value="pickup" required>
    <label for="delivery_pickup">Самовывоз</label><br>
    <input type="radio" id="delivery_courier" name="delivery_method" value="courier" required>
    <label for="delivery_courier">Доставка</label><br><br>

    <label for="payment_method">Способ оплаты:</label><br>
    <div id="payment_methods">
        <input type="radio" id="payment_cash" name="payment_method" value="cash">
        <label for="payment_cash">Наличные</label><br>
        <input type="radio" id="payment_card" name="payment_method" value="card">
        <label for="payment_card">Банковская карта</label><br>
    </div>
    <div id="courier_payment_methods" style="display:none;">
        <input type="radio" id="payment_cash_courier" name="payment_method" value="cash_courier">
        <label for="payment_cash_courier">Наличные курьеру</label><br>
        <input type="radio" id="payment_card_courier" name="payment_method" value="card_courier">
        <label for="payment_card_courier">Банковская карта курьеру</label><br>
    </div>
    
    <div id="address_field" style="display:none;">
        <label for="delivery_address">Адрес доставки:</label>
        <input type="text" id="delivery_address" name="delivery_address"><br><br>
    </div>
    
    <label for="phone_number">Номер телефона:</label>
    <input type="text" id="phone_number" name="phone_number" required><br><br>
    
    <label for="delivery_time">Время доставки:</label>
    <select name="delivery_time" id="delivery_time" required>
        <option value="09:10">09:10</option>
        <option value="09:20">09:20</option>
        <option value="09:30">09:30</option>
        <!-- Добавьте остальные временные шаблоны здесь -->
        <option value="21:50">21:50</option>
        <option value="22:00">22:00</option>
    </select><br><br>

    <label for="activate_prize">Активировать приз:</label><br>
    <input type="checkbox" id="activate_prize" name="activate_prize"><br><br>
    
    <button type="submit">Оформить заказ</button>
</form>
</div>
<script>
document.getElementById('delivery_pickup').addEventListener('change', function() {
    document.getElementById('address_field').style.display = 'none';
    document.getElementById('payment_methods').style.display = 'block';
    document.getElementById('courier_payment_methods').style.display = 'none';
});

document.getElementById('delivery_courier').addEventListener('change', function() {
    document.getElementById('address_field').style.display = 'block';
    document.getElementById('payment_methods').style.display = 'none';
    document.getElementById('courier_payment_methods').style.display = 'block';
});
</script>

<style>
        header{
          position: relative;
        }
        main{
            height: 400px;
        }
</style>