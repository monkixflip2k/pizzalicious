<?php

function renderTemplate($view, $data)
{
    extract($data);
    ob_start();
    require $view;
    $output = ob_get_clean();
    return $output;
}
function truncateText($text, $maxWords = 20) {
    $words = explode(' ', $text);
    if (count($words) > $maxWords) {
        return implode(' ', array_slice($words, 0, $maxWords)) . '...';
    }
    return $text;
} 