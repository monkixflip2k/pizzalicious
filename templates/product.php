<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

$ingredients_list = ""; // Устанавливаем значение по умолчанию
$item_id = $item['id'];

// Получение ингредиентов для товара
$product_id = $item['id'];
$query = "SELECT ingredients.name 
          FROM ingredients 
          JOIN product_ingredients ON ingredients.id = product_ingredients.ingredient_id 
          WHERE product_ingredients.product_id = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result_ingredients = $stmt->get_result();
$ingredients = [];
while ($row = $result_ingredients->fetch_assoc()) {
    $ingredients[] = $row['name'];
}
$ingredients_list = implode(', ', $ingredients);

$stmt->close();

$result = null;
$user_id = null;
if (isset($_COOKIE['user'])) {
    $user = $_COOKIE['user'];
    $result = $mysql->query("SELECT `id` FROM `users` WHERE `username` = '$user'")->fetch_assoc();
    if ($result) {
        $user_id = $result['id'];

        $result = $mysql->query("SELECT * FROM `shopping_cart` WHERE `user_id` = '$user_id' AND `product_id` = '$item_id'")->fetch_assoc();
        
        setcookie('product_id', "$item_id", 0, "/");
    }
}

$mysql->close();
?>

<div class="product" id="product-<?=$item_id?>">
    <div>
        <img class="product_img" src="<?=$item['img_path']?>" alt="">
    </div>
    <div class="product-desc">
        <p><b>Пицца: </b><?=$item['name'];?></p>
        <p><b>Цена: </b><?=$item['price'];?> ₽</p>
        <p class="desc"><b>Описание: </b><?=$item['description']?></p>
        <p class="desc"><b>Ингредиенты: </b><?=htmlspecialchars($ingredients_list)?></p>

        <div class="quantity-selector">
            <label for="quantity">Количество: </label>
            <button type="button" class="quantity-decrease" data-item-id="<?=$item_id?>">-</button>
            <input type="number" id="quantity-<?=$item_id?>" name="quantity" value="1" min="1">
            <button type="button" class="quantity-increase" data-item-id="<?=$item_id?>">+</button>
        </div>

        <div class="cart-actions">
            <?php if ($result == null && isset($_COOKIE['user'])): ?>
                <a href="#" class="add-to-cart" data-item-id="<?=$item_id?>" data-user-id="<?=$user_id?>" data-status="add">Добавить в корзину</a>
            <?php elseif ($result != null && isset($_COOKIE['user'])): ?>
                <a href="#" class="update-cart" data-item-id="<?=$item_id?>" data-user-id="<?=$user_id?>" data-status="add">Добавить еще</a>
                <a href="#" class="remove-from-cart" data-item-id="<?=$item_id?>" data-user-id="<?=$user_id?>" data-status="del">Удалить из корзины</a>
            <?php else: ?>
                <a href="./pageView.php?id=auth.php">Добавить в корзину</a>
            <?php endif; ?>
        </div>

        <?php if (isset($_COOKIE['user'])): ?>
            <?php if ($_COOKIE['user'] == 'admin'): ?>
                <a href="./pageView.php?id=editproduct.php&product_id=<?=$item['id']?>">Изменить товар</a>
                <a href="./templates/phpscripts/deleteproduct.php?product_id=<?=$item_id?>">Удалить товар</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<div id="notification" style="display: none; position: fixed; top: 620px; left: 800px; background: #444; color: white; padding: 10px; border-radius: 5px;"></div>

<script>
    $(document).ready(function() {
        function showNotification(message) {
            var $notification = $('#notification');
            $notification.text(message).fadeIn();

            setTimeout(function() {
                $notification.fadeOut();
            }, 3000);
        }

        function updateQuantity(item_id, increment) {
            var $quantityInput = $('#quantity-' + item_id);
            var currentValue = parseInt($quantityInput.val());
            if (increment) {
                $quantityInput.val(currentValue + 1);
            } else if (currentValue > 1) {
                $quantityInput.val(currentValue - 1);
            }
        }

        $('.quantity-increase').on('click', function() {
            var item_id = $(this).data('item-id');
            updateQuantity(item_id, true);
        });

        $('.quantity-decrease').on('click', function() {
            var item_id = $(this).data('item-id');
            updateQuantity(item_id, false);
        });

        function bindCartActions() {
            $('.add-to-cart, .update-cart, .remove-from-cart').off('click').on('click', function(e) {
                e.preventDefault();

                var item_id = $(this).data('item-id');
                var user_id = $(this).data('user-id');
                var status = $(this).data('status');
                var quantity = $('#quantity-' + item_id).val();

                if (!user_id) {
                    window.location.href = './pageView.php?id=auth.php';
                    return;
                }

                $.ajax({
                    url: './templates/phpscripts/addtoshopcart.php',
                    type: 'GET',
                    data: {
                        item_id: item_id,
                        status: status,
                        user_id: user_id,
                        quantity: quantity
                    },
                    success: function(response) {
                        console.log('Response: ' + response);

                        if (status == 'add') {
                            showNotification('Товар добавлен в корзину');
                            $('#product-' + item_id + ' .cart-actions').html(`
                                <a href="#" class="update-cart" data-item-id="${item_id}" data-user-id="${user_id}" data-status="add">Добавить еще</a>
                                <a href="#" class="remove-from-cart" data-item-id="${item_id}" data-user-id="${user_id}" data-status="del">Удалить из корзины</a>
                            `);
                        } else if (status == 'del') {
                            showNotification('Товар удален из корзины');
                            $('#product-' + item_id + ' .cart-actions').html(`
                                <a href="#" class="add-to-cart" data-item-id="${item_id}" data-user-id="${user_id}" data-status="add">Добавить в корзину</a>
                            `);
                        }

                        bindCartActions();
                    },
                    error: function(error) {
                        console.error('Error: ' + error);
                    }
                });
            });
        }

        bindCartActions();
    });
</script>