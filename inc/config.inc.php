<?php
	const DB_HOST = "localhost";
	const DB_LOGIN = "root";
	const DB_PASSWORD = "";
	const DB_NAME = "eshop";
	
	const ORDERS_LOG = "orders.log";//файл, для хранения заказов (создаться сам)
	
	$basket = [];//создаем корзину
	$count = 0;//кол-во товаров в корзине
	
	$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) /*or die(mysqli_connect_error())*/;//соединение с базой данных
		if(mysqli_connect_errno()){
				
			echo 'Ошибка при подключении баз данных ('.mysqli_connect_errno().'): '.mysqli_connect_error();
			exit();
		}
	
	basketInit();
?>
