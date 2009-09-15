<?php

include_once "include.php";
include_once "stock.php";

$p_user_name = getPost("user_name");

if($p_user_name != "")
{
	/*
	if(!isset($_SESSION['session'])) {
		$_SESSION['session'] = array();
		$session = & $_SESSION['session'];
	}
	*/
	$_SESSION['session'] = array();
	$session = & $_SESSION['session'];

	$query = "select * from stock_player_account where user_name='$p_user_name'";
	$result = q($query);
	$row = f_assoc($result);
	$user_id = $row["user_id"];
	$user_name = $row["user_name"];
	$cash = $row["cash"];
}
else
{
	$session = & $_SESSION['session'];

	$user_id = & $session['user_id'];
	$user_name = & $session['user_name'];
	$cash = & $session['cash'];
	$symbol = & $session['symbol'];
	
	$stock = getStockQuote($symbol);
	$price = $stock['text'];

	$p_action = getPost("action");
	$p_quantity = getPost("quantity");

	$amount = $price * $p_quantity;

	$query = "select * from stock_player_account where user_name='$user_name'";
	$result = q($query);
	$row = f_assoc($result);
	$cash = $row["cash"];

	$query = "select * from stock_portfolio_account where user_id = $user_id and symbol = '$symbol'";
	$result = q($query);
	$row = f_assoc($result);
	$portfolio_quantity = $row["quantity"];
	if ($p_action == "buy") {
		$cash = $cash - $amount;
		if ($portfolio_quantity == "") {
			$portfolio_quantity = $p_quantity;
			$query = "insert into stock_portfolio_account (user_id, symbol, quantity) values ($user_id, '$symbol', $portfolio_quantity)";
		} else {
			$portfolio_quantity = $portfolio_quantity + $p_quantity;
			$query = "update stock_portfolio_account set quantity = $portfolio_quantity where user_id = $user_id and symbol = '$symbol'";
		}
	} else {
		$cash = $cash + $amount;
		$portfolio_quantity = $portfolio_quantity - $p_quantity;
		$query = "update stock_portfolio_account set quantity = $portfolio_quantity where user_id = $user_id and symbol = '$symbol'";
	}
	$result = q($query);

	$query = "update stock_player_account set cash = $cash where user_name = '$user_name'";
	$result = q($query);
}

$session['user_id'] = $user_id;
$session['user_name'] = $user_name;
$session['cash'] = $cash;

echo "<p>username: $user_name</p>";
echo "<p>cash: $cash</p>";

echo '
<form action="check.php" method="post">
 <p>Enter symbol to query: <input type="text" name="symbol" /><input type="submit" value="Check" /></p>
</form>
';

$query = "select * from stock_portfolio_account where user_id = $user_id";
$result = q($query);

while($row = f_assoc($result)){
	$symbol = $row["symbol"];
	$quantity = $row["quantity"];
	echo "<p>Stock : $symbol ; Quantity : $quantity</p>";
}


include "includeEnd.php";

?>