<?php

include_once "include.php";
include_once "stock.php";

$p_symbol = getPost("symbol");

$session = & $_SESSION['session'];
$user_name = & $session['user_name'];
$cash = & $session['cash'];

//echo "$user_name wants to check $p_symbol";
echo "<p>username: $user_name</p>";
echo "<p>cash: $cash</p>";

$stock = getStockQuote($p_symbol);
$symbol = $stock['name'];
$price = $stock['text'];

echo "<p>symbol: $symbol</p>";
echo "<p>price: $price</p>";

$session['symbol'] = $symbol;

simple_form("buy.php", "buy", "To buy this stock:{$sp5}");
simple_form("sell.php", "sell", "To sell this stock:{$sp5}");

include "includeEnd.php";

?>