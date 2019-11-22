<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";
?>
<?php
	include "./inc/head.php";
?>
	<h1>Ваша корзина</h1>
<?php
	if(!$count){//если корзина пуста (пустой массив)
		echo "<h2>Корзина пуста! Вернитесь в <a href='catalog.php'>каталог</a></h2>";
		exit;
	}else{
		echo "<h2>Вернуться в <a href='catalog.php'>каталог</a></h2>";
	}
	$goods = myBasket();
?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Фото</th>
	<th>Год</th>
	<th>Цена, грн.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?php
	$i = 1;
	$sum = 0;
	foreach($goods as $item){//запускаем цикл для вывода массивом
?>
	<tr>
		<td><?= $i++?></td>
		<td><?= $item['title']?></td>
		<td><img src="img/img_product/<?= $item['author']?>.jpg" width="100"></td>
		<td><?= $item['pubyear']?></td>
		<td><?= $item['price']?></td>
		<td><?= $item['quantity']?></td>
		<td><a href="delete_from_basket.php?id=<?= $item['id']?>">Удалить</a></td>
	</tr>
<?
	$sum += $item['price'] * $item['quantity'];
	}
?>
</table>

<h2>Всего товаров в корзине на сумму: <?=$sum?> грн.</h2>

<div align="center">
	<a><input type="button" class="default-btn" value="Оформить заказ!"
                      onClick="location.href='orderform.php'" /></a>
</div>

<?php
	include "./inc/footer.php";
?>







