<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";
	
	$goods = selectAllItems();//присваиваем переменной $goods вызов функции, которая берет из базы данные
	if($goods === false){echo "ERROR!"; exit;}
	if(!count($goods)){echo "EMPTY!"; exit;}
?>
<?php
	$hour = (int) strftime("%H");
	$welcome = "Доброй ночи";//Инициализируем переменную для приветствия.
	if($hour >= 6 and $hour < 12): $welcome = "Доброе утро";
		elseif($hour >= 12 and $hour < 18): $welcome = "Добрый день";
		elseif($hour >= 18 and $hour < 23): $welcome = "Добрый вечер";
	endif;
	
	//Установка локали и выбор значений даты
	//echo iconv("UTF-8");
	setlocale(LC_ALL, "russian");
	$day = strftime('%d');
	$mon = strftime('%B');
	$mon = iconv("windows-1251", "UTF-8", $mon);
	$year = strftime('%Y');
?>

<?php
	include "./inc/head.php";
?>

  <section class="slider">
    <div class="container">
      <div class="slider__inner">
        <div class="slider__item">
          <div class="slider__item-content">
            <div class="slider__title">
              Данный магазин является распродажей книжной продукции
            </div>
            <div class="slider__text">
              Книги в основном находятся в хорошем состоянии
            </div>
          </div>
        </div>
        <div class="slider__item">
          <div class="slider__item-content">
            <div class="slider__title">
              Состояние интересующей книги можно уточнить
            </div>
            <div class="slider__text">
              По желанию сделаем дополнительные фото
            </div>
          </div>
        </div>
        <div class="slider__item">
          <div class="slider__item-content">
            <div class="slider__title">
              Некоторые книги в состоянии, близком к новому
            </div>
            <div class="slider__text">
              Прочитанная книга может подарить новые эмоции
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  
  <section class="services">
    <div class="container">
		<div class="table">
      <!--<div class="services__top">
        <div class="services__title-box">
          <div class="services__title">
            Наши Услуги
          </div>
          <div class="services__text">
            Комплексный подход к вашему вопросу, своевременная правовую помощь, представление интересов во всех судебных
            инстанциях.
          </div>
        </div>
		<div class="services__btn">
          <a href="#">
            Показать все услуги
          </a>
        </div> 
      </div>-->
	   
	  <h2><?= $welcome ?>, Гость!<h2>
	  <h3><?='Сегодня ', $day, ' число, ', $mon, ' месяц, ', $year, ' год.';?><h3>
	  <!--<p>Товаров в <a href="basket.php">корзине</a>: <?= $count?></p>-->
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>Название (Автор)</th>
	<th>Фото</th>
	<th>Год</th>
	<th>Цена</th>
	<th>В корзину</th>
</tr>
<?php
	foreach($goods as $item){//запускаем цикл для вывода массивом
?>
	<tr>
		<td><?= $item['title']?></td>
		<td><img src="img/img_product/<?= $item['author']?>.jpg" height="100"></td>
		<td><?= $item['pubyear']?></td>
		<td><?= $item['price']?></td>
		<td><a href="add2basket.php?id=<?= $item['id']?>">В корзину</a></td>
	</tr>
<?
	}
?>
</table>
	  
     
		</div>
	</div>
  </section>
  
<?php
	include "./inc/footer.php";
?>