<?php
	ob_start();//включаем буферизацию
	include "./inc/head.php";
?>

<?php
/* Основные настройки */
const DB_HOST = "localhost";
const DB_LOGIN = "root";
const DB_PASSWORD = "";
const DB_NAME = "gbook";
$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
/* Основные настройки */
function clearStr($data){//данная функция очищает введенные в форму данные от html тегов и экранирует спец.символы
	global $link;//объявляем $link глобальной переменной
	$data = trim(strip_tags($data));//очищает введенные в форму данные от html тегов
	return mysqli_real_escape_string($link, $data);//экранирует спец.символы
}
/* Сохранение записи в БД */
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$name = clearStr($_POST["name"]);
	$email = clearStr($_POST["email"]);
	$msg = clearStr($_POST["msg"]);
	$sql = "INSERT INTO msgs (name, email, msg) VALUES ('$name', '$email', '$msg')";//создаем sql запрос.
	mysqli_query($link, $sql);//посылаем запрос
	header("Location: " . $_SERVER["REQUEST_URI"]);//избавляемся от буфера метода post
	exit;
	//прописать в начале файла index.php ob_start(); включаем буферизацию
}

/* Сохранение записи в БД */

/* Удаление записи из БД */
if(isset($_GET["del"])){//если существует параметр del в суперглобальной переменной $_GET
	$del = abs((int)$_GET["del"]);//приводим $_GET["del"] к положительному целому числу и присваиваем это число пер.$del (в результате в $del будет либо 0, либо пол. число)
	if($del){//если $del не равно нулю
		$sql = "DELETE FROM msgs WHERE id = $del";
		mysqli_query($link, $sql);
	}
}	
	
/* Удаление записи из БД */
?>
<div class="container">
	<h2>Оставьте отзыв в нашей Гостевой книге</h2>
	<div class="form__box-left">
	<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
	Имя: <br /><input type="text" name="name" /><br />
	Email: <br /><input type="text" name="email" /><br />
	Сообщение: <br /><textarea cols="45" name="msg"></textarea><br />

	<br />

	<input type="submit" class="default-btn" value="Отправить!" />

	</form>
	</div>
<?php
/* Вывод записей из БД */
$sql = "SELECT id, name, email, msg, UNIX_TIMESTAMP(datetime) as dt FROM msgs ORDER BY id DESC";//выбрать все поля, последнее поле(datetime)сконвертировать во временную метку и вернуть в dt. FROM msgs ORDER BY id DESC - последнее сообщение будет выводиться первым.
$res = mysqli_query($link, $sql);
echo "<h3>Всего записей в гостевой книге: " . mysqli_num_rows($res);//равное количеству строк
while($row = mysqli_fetch_assoc($res)){
	$dt = date("d-m-Y H:i:s", $row["dt"]);
	$msg = nl2br($row["msg"]);//для отображения стихов в столбик
	echo <<<MSG
	<h3>
		<a href="{$row['email']}">{$row['name']}</a>
			{$dt} написал<br />{$msg}
	</p>
	<p align="right">
		<a href="http://mysite.local/Ladieswear/reviews.php?id=gbook&del={$row['id']}">Удалить</a>
	</p>
MSG;
}
/* Вывод записей из БД */
?>
</div>

<?php
	include "./inc/footer.php";
?>