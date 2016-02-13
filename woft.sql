-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 18 2016 г., 16:37
-- Версия сервера: 10.1.9-MariaDB
-- Версия PHP: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `woft`
--

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `professor` int(11) NOT NULL,
  `ev_group` int(11) NOT NULL,
  `ev_date` date NOT NULL,
  `ev_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id`, `professor`, `ev_group`, `ev_date`, `ev_text`) VALUES
(63, 30, 2, '2015-11-20', 'Тест'),
(97, 0, 0, '2015-10-01', 'asdasd'),
(98, 0, 0, '2015-10-01', 'asd'),
(104, 31, 3, '2015-10-15', 'ВТОРОЕ СОБЫТИЕ фывфыв'),
(113, 30, 1, '2015-10-01', 'Привет!'),
(114, 31, 1, '0000-00-00', ''),
(116, 31, 1, '2015-10-15', ''),
(120, 34, 21, '2015-11-05', '123457'),
(121, 31, 21, '2015-11-05', ''),
(129, 34, 22, '2015-11-05', '456789'),
(250, 0, 1, '2015-12-15', 'Тест 1'),
(251, 0, 2, '2015-12-17', 'Тест 2'),
(252, 0, 2, '2015-12-19', 'Тест 3'),
(255, 0, 1, '2015-12-16', ''),
(258, 31, 0, '2015-11-02', 'sdf');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `group_name`) VALUES
(0, 'Без группы'),
(1, 'B8475d'),
(2, 'B8419a'),
(3, 'РРР');

-- --------------------------------------------------------

--
-- Структура таблицы `marks`
--

CREATE TABLE `marks` (
  `id_event` int(11) NOT NULL,
  `id_student` int(11) NOT NULL,
  `visit` tinyint(1) NOT NULL,
  `mark` int(11) NOT NULL,
  `id_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `marks`
--

INSERT INTO `marks` (`id_event`, `id_student`, `visit`, `mark`, `id_group`) VALUES
(250, 31, 1, 3, 1),
(255, 31, 1, 6, 1),
(255, 32, 1, 4, 1),
(255, 35, 1, 7, 1),
(250, 32, 1, 7, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `s_hash` text,
  `s_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `s_hash`, `s_time`) VALUES
(1, 36, '80b74c070abaf2b735b983b6ecf430f5', 1447771991),
(2, 36, 'e34bf8260a9bbcf2a0662d92d1b62135', 1447813777),
(3, 37, '57ddbc018259d08845c5cab8f717899c', 1453180329);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `user_password` text NOT NULL,
  `user_info` text NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `contacts` text NOT NULL,
  `rights` int(1) NOT NULL,
  `if_stuff` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `user_password`, `user_info`, `group_id`, `contacts`, `rights`, `if_stuff`) VALUES
(31, 'asd', '3dad9cbf9baaa0360c0f2ba372d25716', 'Коклюхин Толя', 1, 'Контактики', 3, 1),
(32, 'asdasd', '059091c6617924e5d255581262f0b57b', 'Иванкин Иван Иванович', 1, 'Falscroom', 0, 0),
(33, 'FAFAFA', 'f711e90591d86de08de63f5c6b7c129a', 'FAFAFA', 0, 'FAFAFA', 3, 0),
(35, 'test', 'fb469d7ef430b0baf0cab6c436e70375', 'test', 3, 'test', 0, 1),
(36, 'alex', '28c8edde3d61a0411511d3b1866f0636', 'ddd', 2, 'ddd', 0, 0),
(37, 'Falscroom', '059091c6617924e5d255581262f0b57b', 'Falscroom', NULL, 'Falscroom', 3, 1),
(38, 'qwerty', '897c8fde25c5cc5270cda61425eed3c8', 'qwerty', 0, 'qwerty', 1, 0),
(39, 'qwertyqwerty', '3d90daaab376e7a60d763f64255910fd', 'qwertyqwerty', NULL, 'qwertyqwerty', 1, 1),
(40, 'qwerty1', '1f32aa4c9a1d2ea010adcf2348166a04', 'Магомедов Руслан Магомедович', 2, '03', 1, 0),
(41, 'qwerty2', '1f32aa4c9a1d2ea010adcf2348166a04', 'Макеев Александр', 2, '000', 1, 0),
(42, 'qwerty3', '1f32aa4c9a1d2ea010adcf2348166a04', 'Шландаков Алексей', 2, '1234', 1, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ev_group` (`ev_group`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_name` (`group_name`(10)) USING BTREE;

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;
--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
