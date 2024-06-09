<?php
$id = $_COOKIE['product_id'];
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
$mysql -> query("DELETE FROM `goods`
WHERE `id` = '$id'");
$mysql -> close();
header('Location: ../../index.php');
