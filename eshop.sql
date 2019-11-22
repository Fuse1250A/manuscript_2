-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 13 2019 г., 15:40
-- Версия сервера: 5.5.62
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `eshop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `catalog`
--

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Без названия',
  `author` varchar(255) DEFAULT NULL,
  `pubyear` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `catalog`
--

INSERT INTO `catalog` (`id`, `title`, `author`, `pubyear`, `price`) VALUES
(1, 'Маркетинг менеджмент (Филипп Котлер)', 'kotler', 2000, 25),
(2, 'Секреты BIOS (Антон Трасковский)', 'bios', 2003, 25),
(3, 'Хвороби шкiри. Хвороби, що передаються ставевим шляхом (Володимир Савчак, Свiтлана Галникiна)', 'zppp', 2001, 100),
(5, 'Красное и черное (Стендаль)', 'redblack', 1990, 10),
(6, 'Караоке для дамы с собачкой (Татьяна Полякова)', 'pol', 2004, 10),
(7, 'Любовь не выбирает (Эми Эндрюс)', 'loveno', 2013, 10),
(8, 'Полуночный поцелуй (Ширли Джамп)', 'polpoc', 2013, 10),
(9, 'Вкус неба (Диана Машкова)', 'vkusneba', 2013, 10),
(10, 'Проклята краса (Дарина Гнатко)', 'krasa', 2016, 50),
(11, 'Неферити (Мишель Моран)', 'nef', 2019, 100),
(12, 'Курортный роман (Юлия Шилова)', 'shilova', 2008, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `pubyear` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `orderid` varchar(50) NOT NULL DEFAULT '',
  `datetime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `title`, `author`, `pubyear`, `price`, `quantity`, `orderid`, `datetime`) VALUES
(20, 'Секреты BIOS (Антон Трасковский)', 'bios', 2003, 25, 1, '5dcbc94ab030f', 1573645563),
(21, 'Проклята краса (Дарина Гнатко)', 'krasa', 2016, 50, 1, '5dcbedff6d6f2', 1573647930),
(22, 'Неферити (Мишель Моран)', 'nef', 2019, 100, 1, '5dcbedff6d6f2', 1573647930);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
