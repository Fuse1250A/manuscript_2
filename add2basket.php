<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";
	
	$id = clearInt($_GET["id"]);//записываем в $id идентификатор, который приходит методом GET в $_GET
	if($id){
		add2Basket($id);//вызываем функцию add2Basket, передавая в нее
		header("Location: catalog.php");
		exit;
	}	//$id = очищенное целое пол.число, пришедшее из $_GET["id"], которое добавили
		//в функцию add2Basket($id)
?>