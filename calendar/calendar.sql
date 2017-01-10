-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 10 2017 г., 10:35
-- Версия сервера: 5.6.16
-- Версия PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `cvr_iconmaster`
--

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_dynamic`
--

CREATE TABLE IF NOT EXISTS `calendar_dynamic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `difference` int(11) NOT NULL,
  `introduction` varchar(200) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `calendar_dynamic`
--

INSERT INTO `calendar_dynamic` (`id`, `title`, `difference`, `introduction`, `text`) VALUES
(1, '', -70, '', ''),
(2, '', -49, '', ''),
(3, '', -42, '', ''),
(4, '', -15, '', ''),
(5, '', -8, '', ''),
(6, '', -7, '', ''),
(7, '', -2, '', ''),
(8, '', -1, '', ''),
(9, 'Пасха', 0, '', ''),
(10, '', 39, '', ''),
(11, '', 49, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_static`
--

CREATE TABLE IF NOT EXISTS `calendar_static` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `month` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `introduction` varchar(200) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `calendar_static`
--

INSERT INTO `calendar_static` (`id`, `title`, `month`, `day`, `introduction`, `text`) VALUES
(1, 'title1', 1, 7, '', ''),
(2, 'title2', 1, 15, '', ''),
(3, 'title3', 2, 9, '', ''),
(4, 'title4', 1, 19, '', ''),
(5, 'title5', 7, 12, '', ''),
(6, 'title6', 7, 22, '', ''),
(7, 'title7', 12, 9, '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
