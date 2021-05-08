-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 5 月 08 日 02:17
-- サーバのバージョン： 5.7.33
-- PHP のバージョン: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`item_id`, `name`, `stock`, `price`, `image`, `status`, `created`, `updated`) VALUES
(32, 'ねこ', 57, 30000, 'ny1owjn3yqs0cow8w4ws.jpg', 1, '2019-08-09 09:12:30', '2021-04-28 23:33:48'),
(33, 'ハリネズミ', 79, 50000, '16scmunsexdwcosw88g0.jpg', 1, '2019-08-09 09:13:33', '2021-04-30 13:40:46'),
(35, 'いぬ', 99, 40000, '3t3oi7yl236s8ccs08gw.jpg', 1, '2021-04-28 23:19:34', '2021-05-03 14:38:00'),
(36, 'うま', 9, 100000, '1hx4fvfb16sksokswwwk.jpg', 1, '2021-04-28 23:20:40', '2021-05-03 14:38:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `orders`
--

CREATE TABLE `orders` (
  `order_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `orders`
--

INSERT INTO `orders` (`order_number`, `user_id`, `order_datetime`) VALUES
(1, 4, '2021-04-20 09:31:10'),
(3, 4, '2021-04-20 09:39:57'),
(6, 4, '2021-04-20 10:00:34'),
(7, 4, '2021-04-20 22:01:31'),
(8, 1, '2021-04-21 14:52:56'),
(9, 1, '2021-04-21 15:21:19'),
(10, 4, '2021-04-21 20:16:10'),
(11, 1, '2021-04-21 20:16:53'),
(12, 4, '2021-04-23 10:09:07'),
(13, 5, '2021-04-23 13:38:14'),
(14, 5, '2021-04-23 14:27:54'),
(15, 5, '2021-04-28 23:16:17'),
(16, 4, '2021-04-28 23:33:48'),
(17, 4, '2021-04-28 23:34:16'),
(18, 5, '2021-04-30 13:40:46'),
(19, 5, '2021-04-30 13:47:59'),
(20, 5, '2021-05-02 14:35:47'),
(21, 5, '2021-05-02 14:36:10'),
(22, 4, '2021-05-02 14:39:17'),
(23, 5, '2021-05-03 14:38:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `order_details`
--

CREATE TABLE `order_details` (
  `order_number` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `order_details`
--

INSERT INTO `order_details` (`order_number`, `item_id`, `amount`, `price`) VALUES
(1, 32, 2, 30000),
(1, 33, 1, 50000),
(3, 32, 1, 30000),
(3, 33, 1, 50000),
(6, 32, 1, 30000),
(6, 33, 1, 50000),
(7, 32, 2, 30000),
(7, 33, 1, 50000),
(8, 32, 2, 30000),
(8, 33, 1, 50000),
(9, 32, 2, 30000),
(9, 33, 1, 50000),
(10, 32, 19, 30000),
(10, 33, 11, 50000),
(11, 32, 11, 30000),
(11, 33, 2, 50000),
(12, 32, 1, 30000),
(12, 33, 1, 50000),
(13, 32, 5, 30000),
(13, 33, 1, 50000),
(14, 32, 1, 30000),
(14, 33, 1, 50000),
(15, 32, 1, 30000),
(15, 33, 1, 50000),
(16, 32, 3, 30000),
(16, 33, 2, 50000),
(17, 35, 2, 40000),
(17, 36, 1, 100000),
(18, 33, 1, 50000),
(18, 35, 2, 40000),
(18, 36, 2, 100000),
(19, 35, 1, 40000),
(19, 36, 1, 100000),
(20, 35, 37, 40000),
(21, 35, 8, 40000),
(22, 36, 36, 100000),
(23, 35, 1, 40000),
(23, 36, 1, 100000);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '2',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `name`, `password`, `type`, `created`, `updated`) VALUES
(1, 'sampleuser', '$2y$10$s2Kh9TT526HB0bQLYudLgel.xu.BlLvLea5EWI.LfU7ft6Ueedi7O', 2, '2021-05-06 11:40:01', '2019-08-07 01:17:12'),
(4, 'admin', '$2y$10$IREuephNmEZgq51x0pPtbe2kFmbrPfIQxtmH/DUN.nOcqtkwNgt4K', 1, '2021-05-06 11:37:32', '2019-08-07 10:45:11'),
(5, 'aaaaaa', '$2y$10$.9788MmYbKt1/tce5N9c0eBasNOweNPFNjkRkXu/nHTa89uMbof.u', 2, '2021-05-06 11:35:04', '2021-04-12 17:30:27'),
(6, 'pppppp', '$2y$10$KzeR7YTb4vBu3RxIvaktieEaqfG4qKHk4C0m5.8tE2lNoq.fCeo2O', 2, '2021-05-06 11:07:06', '2021-05-06 11:07:06'),
(7, 'eeeeee', '$2y$10$WRCkv.FxJyD2NJP6kr5qnenAuhNQgw2TNpyxm7Nol8qQlIY1QzCFe', 2, '2021-05-06 11:44:47', '2021-05-06 11:44:47');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- テーブルのインデックス `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_number`);

--
-- テーブルのインデックス `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_number`,`item_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- テーブルの AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `order_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
