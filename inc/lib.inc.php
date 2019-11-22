<?php
	function clearStr($data){//создаем функцию, которая очищает введенные в форму данные(string(название, автор)) от html тегов и экранирует спец.символы
	global $link;//объявляем $link глобальной переменной
	$data = trim(strip_tags($data));//очищает введенные в форму данные(string(название, автор)) от html тегов
	return mysqli_real_escape_string($link, $data);//экранирует спец.символы в(string(название, автор))
	}
	
	function clearInt($data){//создаем функцию, которая приводит введенные в форму данные
		return abs((int)$data);//(integer(год выпуска, цена)) в положительное целое число
	}
	
	function addItemToCatalog($title, $author, $pubyear, $price){//добавляем в базу
		$sql = 'INSERT INTO catalog (title, author, pubyear, price) VALUES (?, ?, ?, ?)';//подготовленный запрос к БД(insert-вставить в таблицу catalog(название, автор, год, цена) значения из форм
		global $link;//объявляем $link глобальной переменной
		if (!$stmt = mysqli_prepare($link, $sql))//(prepare-подготовить) соединение($link) и SQL выражение к выполнению(возвращает объект запроса или FALSE в случае ошибки)
			return false;
		mysqli_stmt_bind_param($stmt, "ssii", $title, $author, $pubyear, $price);//bind-привязать переменные к меткам параметров в SQL выражении, которое было подготовлено фукнцией mysqli_prepare(). ssii(2string строковых параметра, 2int целых числа)
		mysqli_stmt_execute($stmt);//execute-выполнить подготовленный запрос
		mysqli_stmt_close($stmt);
		return true;
	}
	
	function selectAllItems(){//задача функции взять  из базы данные
		global $link;//даем $link статус глобальной, чтобы php мог использовать ее из другого файла
		$sql = 'SELECT id, title, author, pubyear, price FROM catalog';
		
		if (!$result = mysqli_query($link, $sql))//если соединение и запрос в БД не исполнился
			return false;//вываливаемся из функции
		$items = mysqli_fetch_all($result, MYSQLI_ASSOC);//возвращает массив массивов в ассоциативном виде
		mysqli_free_result($result);//очищает($result)
		return $items;//
	}
	
	function saveBasket(){//функция сохранения товара в корзину
		global $basket;//делаем глобальной(лежит в config.inc.php)
		$basket = base64_encode(serialize($basket));//поскольку корзина-массив, мы его сериализуем массив в строковое представление, а потом кодируем данные способом MIME base64	
		setcookie('basket', $basket, 0x7FFFFFFF);//посылаем преобразованные данные в cookie
	}
	
	function basketInit(){//функция спрашивает первый раз человек пришел или нет(есть ли такая корзина?)
		global $basket, $count;
		if(!isset($_COOKIE['basket'])){//если не(существует)пришла кука с именем basket
			$basket = ['orderid'=>uniqid()];//добавляем в массив $basket ключ 'orderid' в который с помощью uniqid Генерируеv уникальный ID
			saveBasket();//вызываем функцию saveBasket
		}else{
			$basket = unserialize(base64_decode($_COOKIE['basket']));//поскольку корзина-массив, мы его десериализуем из строкового в массив, а потом декодируем данные из MIME base64 в нормальный вид
			$count = count($basket) - 1;//количество товара в корзине
		}
	}
	
	function removeBasket(){//очистка корзины
		setcookie('basket', 'deleted', time()-3600);
	}
	
	function add2Basket($id){//передаем в функцию идентификатор
		global $basket;
		$basket[$id] = 1;//поскольку $basket массив, добавляем в массив элемент, который такой же как идентификатор, по умолчанию присваиваем 1
		saveBasket();//сохраняем корзину
	}
	
	function myBasket(){
		global $link, $basket;
		$goods = array_keys($basket);//array_keys возвращает ключи массива (получается массив с первым значением order id, и послед. значениями id книг, напр.([order id][3][5][2])
		array_shift($goods);//удаляет первый ключ из массива (order id), остается массив с id книгами, напр ([3][5][2])
		if(!$goods)//если массив пустой
			return false;
		$ids = implode(",", $goods);//implode — объединяет элементы массива в строку через запятую напр. 3,5,2
		$sql = "SELECT id, author, title, pubyear, price FROM catalog WHERE id IN ($ids)";//подготавливаем запрос, в котором выбираем
		if(!$result = mysqli_query($link, $sql))//если нет соединения к базе данных и запрос в базу не поступил
			return false;//возвращаем false
		$items = result2Array($result);//присваиваем переменной результат функции result2Array(массив массивов(title, author, pubyear, price, quantity))
		mysqli_free_result($result);//освобождает память, связанную с результатом
		return $items;//возвращаем записанный в $items массив массивов(title, author, pubyear, price, quantity)) 
	}
	
	function result2Array($data){//функция принимает результат выполнения функции myBasket и возвращает ассоциативный массив товаров, дополненный их количеством
		global $basket;
		$arr = [];//создаем пустой массив
		while($row = mysqli_fetch_assoc($data)){//каждую строку fetch-получить в assoc-ассоциативный массив с помощью цикла (получаем массив с title, author, pubyear, price)
			$row['quantity'] = $basket[$row['id']];//добавляем в массив новый элемент с ключем['quantity'] (количество)
		$arr[] = $row;
		}
		return $arr;//возвращаем записанный в $arr массив массивов(title, author, pubyear, price, quantity))
	}
	
	function deleteItemFromBasket($id){//функция удаления товара из корзины
		global $basket;
		unset($basket[$id]);
		saveBasket();
	}
	
	function saveOrder($datetime){
		global $link, $basket;
		$goods = myBasket();
		$stmt = mysqli_stmt_init($link);
		$sql = 'INSERT INTO orders (
									title,
									author,
									pubyear,
									price,
									quantity,
									orderid,
									datetime)
				VALUES (?, ?, ?, ?, ?, ?, ?)';
		if (!mysqli_stmt_prepare($stmt, $sql)) return false;
		foreach($goods as $item){
			mysqli_stmt_bind_param($stmt, "ssiiisi",
								   $item['title'],
								   $item['author'],
								   $item['pubyear'],
								   $item['price'],
								   $item['quantity'],
								   $basket['orderid'],
								   $datetime);
			mysqli_stmt_execute($stmt);
		} mysqli_stmt_close($stmt);
		removeBasket();
		return true;
	}
	
	function getOrders(){
		global $link;
		if(!is_file(ORDERS_LOG))//существует ли файл?
			return false;
		/* Получаем в виде массива персональные данные пользователей из файла */
		$orders = file(ORDERS_LOG);// зачитываем файл в массив (построчно). Какая длина массива (Сколько строк, столько и заказов)
		/* Массив, который будет возвращен функцией */
		$allorders = [];//cоздали массив
		foreach ($orders as $order) {//прогоняем массив через цикл (сколько строк в массиве, столько и же заказов (1заказ=1строке массива), соот. столько и итераций в цикле. В $order кидается строка, разделенная палками |
			list($name, $email, $phone, $address, $orderid, $date) = explode("|", $order);//разбиваем массив по палкам в соответсвующие переменные
			/* Промежуточный массив для хранения информации о конкретном заказе */
			$orderinfo = [];//создаем промежуточный массив с персональными данными пользователя
			/* Сохранение информацию о конкретном пользователе */
			$orderinfo["name"] = $name;
			$orderinfo["email"] = $email;
			$orderinfo["phone"] = $phone;
			$orderinfo["address"] = $address;
			$orderinfo["orderid"] = $orderid;
			$orderinfo["date"] = $date;//товары, заказанные пользователем
			/* SQL-запрос на выборку из таблицы orders всех товаров для конкретного покупателя */
			$sql = "SELECT title, author, pubyear, price, quantity
			FROM orders
			WHERE orderid = '$orderid' AND datetime = $date";//делаем выборку из базы данных
			/* Получение результата выборки */
			if(!$result = mysqli_query($link, $sql))//если не получается соединение с базой данных и выборка из базы данных(записать в $result)
				return false;
			$items = mysqli_fetch_all($result, MYSQLI_ASSOC);//mysqli_fetch_all-Выбирает все строки из результирующего набора и помещает их в ассоциативный массив
			mysqli_free_result($result);//Освобождаем память от результата запроса
			/* Сохранение результата в промежуточном массиве */
			$orderinfo["goods"] = $items;//создаем дополнительную ячейку в массиве и закидываем туда товары пользователя
			/* Добавление промежуточного массива в возвращаемый массив */
			$allorders[] = $orderinfo;//в массиве $allorders[] создаем дополнительную ячейку и добавляем в нее массив $orderinfo
		}
		return $allorders;//вернули массив $allorders
	}//в рез. ф-ции получаем огромный многомерный массив $allorders, где каждый его элемент-отдельный заказ(тоже массив $orderinfo)
	 //Каждый заказ(массив $orderinfo) тоже являестя массивом, содержащим $name(имя юзера), $email(почту), $phone(телефон), $address(адрес), $orderid(номер заказа), $date(дата и время заказа), $items(заказанные товары)
	//$items(заказанные товары), тоже является массивом
?>
