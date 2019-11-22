<?php
	// подключение библиотек
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/config.inc.php";

	$title = clearStr($_POST["title"]);//вызываем функцию clearStr, очищая принимаемые данные из Название
	$author = clearStr($_POST["author"]);//вызываем функцию clearStr, очищая принимаемые данные из Автор
	$pubyear = clearInt($_POST["pubyear"]);//вызываем функцию clearStr, очищая принимаемые данные из Год издания
	$price = clearInt($_POST["price"]);//вызываем функцию clearStr, очищая принимаемые данные из Цена
	
	if(!addItemToCatalog($title, $author, $pubyear, $price)){
		echo 'Произошла ошибка при добавлении товара в каталог';
	}else{
		header("Location: add2cat.php");
		exit;
	}
		
?>