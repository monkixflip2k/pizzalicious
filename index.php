<?php

require_once("data.php");
require_once("render-Template.php");

$header_content = renderTemplate('templates/header.php', ['items' => $items_list]);

$page_content = renderTemplate('templates/main.php', ['items' => $items_list]);

$layout_content = renderTemplate('templates/layout.php', ['title' => "Abob",'content' => $page_content, 'header' => $header_content]);

echo $layout_content;