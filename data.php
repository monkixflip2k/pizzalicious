<?php

$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
$items_list = $mysql -> query("SELECT * FROM `goods` 
WHERE 1");
    