<?php
	require "inc/lib.inc.php";
	require "inc/config.inc.php";
	
	$name = clearStr($_POST["name"]);
	$email = clearStr($_POST["email"]);
	$phone = clearStr($_POST["phone"]);
	$address = clearStr($_POST["address"]);
	$oid = $basket["orderid"];
	$dt = time();
	$order = "$name|$email|$phone|$address|$oid|$dt\n";
	file_put_contents("admin/".ORDERS_LOG, $order, FILE_APPEND);
	saveOrder($dt);
?>
<?php
	include "./inc/head.php";
?>
	<h1>Ваш заказ принят. Мы свяжимся с Вами в ближайшее время</h1>
	<h2><a href="catalog.php">Вернуться в каталог товаров</a></h2>
<?php
	include "./inc/footer.php";
?>