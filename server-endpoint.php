<?php
// server-endpoint.php

$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$items_per_page = 10;
$items = range(1, 100);
$total_items = count($items);
$start = $page * $items_per_page;
$end = min($start + $items_per_page, $total_items);

$response = '<ul>';
for ($i = $start; $i < $end; $i++) {
    $response .= '<li>Item ' . $items[$i] . '</li>';
}
$response .= '</ul>';

echo $response;
?>
