<?php

require_once("data.php");
require_once("render-Template.php");

$id = $_GET["id"];

foreach($items_list as $item){
    if($item['id'] == $id) {
        echo renderTemplate('templates/product.php', ['item' => $item]);
        exit();
    }
}