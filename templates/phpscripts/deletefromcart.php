<?php
$user_id = $_GET['user_id'];
$product_id = $_GET['product_id'];
    $mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
    $mysql -> query("DELETE FROM `shopping_cart`
    WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'");
    $mysql -> close();
    header('Location: ../../pageView.php?id=shoppingcart.php');