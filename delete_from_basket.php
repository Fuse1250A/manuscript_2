<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";

	$id = clearInt($_GET["id"]);//записываем в $id идентификатор, который приходит методом GET в $_GET
	if(id){
		deleteItemFromBasket($id);
		header("Location: basket.php");
		exit;
	}
?>