<!DOCTYPE html>
<?php
	include "./inc/head.php";
?>
	
	<div class="container">
	<h1>Оформление заказа</h1>
	<div class="form__box-left">
	<form action="saveorder.php" method="post">
		<p>Заказчик: <input type="text" name="name" size="50" />
		<p>Email заказчика: <input type="text" name="email" 
					size="50" />
		<p>Телефон для связи: <input type="text" name="phone" 
						size="50" />
		<p>Адрес доставки: <input type="text" name="address" 
						size="50" />
		<p><input type="submit" class="default-btn" value="Заказать" />
	</form>
	</div>
	</div>
<?php
	include "./inc/footer.php";
?>