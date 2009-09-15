<?php

include_once "include.php";
include_once "stock.php";

$session = & $_SESSION['session'];

$user_name = & $session['user_name'];
$cash = & $session['cash'];
$symbol = & $session['symbol'];

echo "<p>username: $user_name</p>";
echo "<p>cash: $cash</p>";
echo "<p>symbol: $symbol</p>";

$stock = getStockQuote($symbol);
$price = $stock['text'];

echo "<p>price: $price</p>";

echo '
<form action="front.php" method="post">
 <p>Enter quantity to buy: <input type="text" name="quantity" /><input type="submit" name="action" value="buy" /></p>
</form>
';

include "includeEnd.php";

?>