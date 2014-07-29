-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2014 年 07 月 14 日 15:05
-- 伺服器版本: 5.6.14
-- PHP 版本： 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `matsu`
--

-- --------------------------------------------------------

--
-- 資料表結構 `errors`
--

CREATE TABLE IF NOT EXISTS `errors` (
`id` int(11) unsigned NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `object_id` int(11) NOT NULL DEFAULT '0',
  `object_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_read` int(11) NOT NULL DEFAULT '0',
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `errors`
--

INSERT INTO `errors` (`id`, `message`, `object_id`, `object_name`, `is_read`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, '使用 Facebook 登入失敗! IP: 127.0.0.1', 0, '', 0, 1, '2014-07-12 11:25:45', '2014-07-12 11:25:45');

-- --------------------------------------------------------

--
-- 資料表結構 `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(12);

-- --------------------------------------------------------

--
-- 資料表結構 `pageviews`
--

CREATE TABLE IF NOT EXISTS `pageviews` (
`id` int(11) unsigned NOT NULL,
  `model_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` int(11) NOT NULL,
  `counts` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- 資料表的匯出資料 `pageviews`
--

INSERT INTO `pageviews` (`id`, `model_name`, `model_id`, `counts`, `date`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'units', 1, 34, '2014-07-12', 1, '2014-07-12 11:28:32', '2014-07-12 22:56:58'),
(2, 'units', 3, 6, '2014-07-12', 1, '2014-07-12 11:34:04', '2014-07-12 13:08:45'),
(3, 'units', 2, 11, '2014-07-12', 1, '2014-07-12 11:34:29', '2014-07-12 22:18:04'),
(4, 'units', 5, 2, '2014-07-12', 1, '2014-07-12 11:39:19', '2014-07-12 13:02:32'),
(5, 'units', 7, 22, '2014-07-12', 1, '2014-07-12 11:39:39', '2014-07-12 23:02:17'),
(6, 'units', 6, 10, '2014-07-12', 1, '2014-07-12 11:39:44', '2014-07-12 22:25:36'),
(7, 'units', 8, 5, '2014-07-12', 1, '2014-07-12 11:47:18', '2014-07-12 22:56:24'),
(8, 'units', 9, 13, '2014-07-12', 1, '2014-07-12 11:48:15', '2014-07-12 23:01:06'),
(9, 'units', 10, 7, '2014-07-12', 1, '2014-07-12 11:49:19', '2014-07-12 23:03:47'),
(10, 'units', 11, 6, '2014-07-12', 1, '2014-07-12 11:53:29', '2014-07-12 22:56:29'),
(11, 'units', 12, 5, '2014-07-12', 1, '2014-07-12 11:54:38', '2014-07-12 13:02:36'),
(12, 'units', 4, 1, '2014-07-12', 1, '2014-07-12 13:01:33', '2014-07-12 13:01:33'),
(13, 'units', 13, 23, '2014-07-12', 1, '2014-07-12 18:57:21', '2014-07-12 23:01:28'),
(14, 'units', 14, 5, '2014-07-12', 1, '2014-07-12 18:59:21', '2014-07-12 22:28:28'),
(15, 'units', 15, 37, '2014-07-12', 1, '2014-07-12 19:02:50', '2014-07-12 23:08:13'),
(16, 'units', 16, 5, '2014-07-12', 1, '2014-07-12 19:09:42', '2014-07-12 19:41:22'),
(17, 'units', 18, 2, '2014-07-12', 1, '2014-07-12 19:14:02', '2014-07-12 19:41:27'),
(18, 'units', 17, 4, '2014-07-12', 1, '2014-07-12 19:20:57', '2014-07-12 22:48:25'),
(19, 'units', 19, 7, '2014-07-12', 1, '2014-07-12 22:28:29', '2014-07-12 23:01:08'),
(20, 'units', 1, 2, '2014-07-13', 1, '2014-07-13 08:18:30', '2014-07-13 17:06:35'),
(21, 'units', 15, 5, '2014-07-13', 1, '2014-07-13 08:18:50', '2014-07-13 17:06:26'),
(22, 'units', 13, 2, '2014-07-13', 1, '2014-07-13 08:25:34', '2014-07-13 17:12:25'),
(23, 'units', 20, 4, '2014-07-13', 1, '2014-07-13 08:26:19', '2014-07-13 08:27:36'),
(24, 'units', 18, 1, '2014-07-13', 1, '2014-07-13 08:27:25', '2014-07-13 08:27:25'),
(25, 'units', 2, 1, '2014-07-13', 1, '2014-07-13 17:11:38', '2014-07-13 17:11:38');

-- --------------------------------------------------------

--
-- 資料表結構 `temp_pictures`
--

CREATE TABLE IF NOT EXISTS `temp_pictures` (
`id` int(11) unsigned NOT NULL,
  `file_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `for` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- 資料表的匯出資料 `temp_pictures`
--

INSERT INTO `temp_pictures` (`id`, `file_name`, `for`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, '30091_53c1199233603.jpg', 'unit_picture_1', 0, '2014-07-12 19:18:42', '2014-07-12 19:18:46'),
(2, '15161_53c119df429cb.jpg', 'unit_picture_2', 0, '2014-07-12 19:19:59', '2014-07-12 19:20:04'),
(3, '17790_53c119df8f855.jpg', 'unit_picture_3', 0, '2014-07-12 19:19:59', '2014-07-12 19:20:07'),
(4, '22310_53c11a88f213e.jpg', 'unit_picture_4', 0, '2014-07-12 19:22:48', '2014-07-12 19:22:52'),
(5, '24423_53c11a8965f27.jpg', 'unit_picture_5', 0, '2014-07-12 19:22:49', '2014-07-12 19:22:55'),
(6, '25110_53c11d432ff85.jpg', 'unit_picture_6', 0, '2014-07-12 19:34:26', '2014-07-12 19:34:45'),
(7, '10135_53c11d45daa98.jpg', 'unit_picture_7', 0, '2014-07-12 19:34:29', '2014-07-12 19:35:01'),
(8, '18106_53c11d7a61533.jpg', 'unit_picture_8', 0, '2014-07-12 19:35:22', '2014-07-12 19:35:38'),
(9, '31083_53c11d7b92a88.jpg', 'unit_picture_9', 0, '2014-07-12 19:35:23', '2014-07-12 19:35:50');

-- --------------------------------------------------------

--
-- 資料表結構 `units`
--

CREATE TABLE IF NOT EXISTS `units` (
`id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `introduction` text COLLATE utf8_unicode_ci,
  `open_time` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `score` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `comment_counts` int(11) NOT NULL DEFAULT '0',
  `pageview` int(11) NOT NULL DEFAULT '0',
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- 資料表的匯出資料 `units`
--

INSERT INTO `units` (`id`, `user_id`, `name`, `introduction`, `open_time`, `address`, `status`, `latitude`, `longitude`, `score`, `comment_counts`, `pageview`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 1, '北港朝天宮', '北港朝天宮，俗稱北港媽祖廟，位於台灣雲林縣北港鎮中山路178號，是一座主要奉祀媽祖的廟宇，並已被列為中華民國國定古蹟', '', '651台灣雲林縣北港鎮中山路162號', 'certified', '23.567645401147686', '120.30465960502625', '5', 0, 36, 1, '2014-07-12 11:26:33', '2014-07-13 17:06:35'),
(2, 1, '北港義民廟', '北港義民廟', '', '651台灣雲林縣北港鎮旌義街20號', 'certified', '23.56765769355891', '120.30293226242065', '4', 0, 12, 1, '2014-07-12 11:30:58', '2014-07-13 17:11:38'),
(3, 1, '北港武德宮', '五路財神爺廟', '', '651台灣雲林縣北港鎮華勝路330-410號', 'certified', '23.58110736052288', '120.29865145683289', '0', 0, 6, 1, '2014-07-12 11:31:55', '2014-07-12 13:08:45'),
(4, 1, '北港聖安宮', '五年千歲', '', '651台灣雲林縣北港鎮民治路33號', 'certified', '23.57407663353991', '120.30090987682343', '0', 0, 1, 1, '2014-07-12 11:33:10', '2014-07-12 13:01:33'),
(5, 1, '統聯客運', '統聯客運', '', '651台灣雲林縣北港鎮中正路129號', 'certified', '23.57008419300869', '120.30058264732361', '0', 0, 2, 1, '2014-07-12 11:37:25', '2014-07-12 13:02:32'),
(6, 1, '嘉義客運', '嘉義客運', '', '651台灣雲林縣北港鎮文化路19號', 'certified', '23.570354620768562', '120.30219733715057', '0', 0, 10, 1, '2014-07-12 11:37:41', '2014-07-12 22:25:36'),
(7, 1, '日統客運', '日統客運', '', '651台灣雲林縣北港鎮華南路', 'certified', '23.57181492104947', '120.30008375644684', '2.5', 0, 22, 1, '2014-07-12 11:38:18', '2014-07-12 23:02:17'),
(8, 1, '建國國中', '建國國中', '', '651台灣雲林縣北港鎮大同路468號', 'certified', '23.573653794600204', '120.29544353485107', '0', 0, 5, 1, '2014-07-12 11:42:55', '2014-07-12 22:56:24'),
(9, 1, '北港國中', '北港國中', '', '651台灣雲林縣北港鎮民生路157-249號', 'certified', '23.565511421122775', '120.29922008514404', '1', 0, 13, 1, '2014-07-12 11:43:20', '2014-07-12 23:01:06'),
(10, 1, '南陽國小', '南陽國小', '', '651台灣雲林縣北港鎮光明路118號', 'certified', '23.566698', '120.301062', '0', 0, 7, 1, '2014-07-12 11:43:37', '2014-07-12 23:03:47'),
(11, 1, '北辰國小', '北辰國小', '', '651台灣雲林縣北港鎮成功路30號', 'certified', '23.577272465207784', '120.30305027961731', '5', 0, 6, 1, '2014-07-12 11:52:11', '2014-07-12 22:56:29'),
(12, 1, '北港高中', '北港高中', '', '651台灣雲林縣北港鎮成功路26號', 'certified', '23.57711513377703', '120.30449867248535', '0', 0, 5, 1, '2014-07-12 11:54:21', '2014-07-12 13:02:36'),
(13, 1, '阿杏小籠湯包', '阿杏小籠湯包', '下午兩點~晚上八點', '651台灣雲林縣北港鎮大同路396號', 'certified', '23.57346204160903', '120.29715478420258', '5', 0, 25, 1, '2014-07-12 18:56:46', '2014-07-13 17:12:25'),
(14, 1, '福安鴨肉飯', '福安鴨肉飯', '', '651台灣雲林縣北港鎮中山路37-79號', 'certified', '23.565351617075862', '120.30421167612076', '5', 0, 5, 1, '2014-07-12 18:58:43', '2014-07-12 22:28:28'),
(15, 1, '老受鴨肉飯', '民國前三年蔡家曾祖父為養育五子、六女，以扛擔方式販售白煮鴨及燻鴨維生，期間子女陸續長大成人，為圖精緻鴨肉口感，令其二子學習如何精選鴨肉品種食材，三子、五子則專攻烹調技術，做出口味獨特煙燻鴨肉、鴨肉羹，於北港深受好評，唯長子全盲，人稱「智高伯」，雖因雙目失明，以占卜為生受人敬重，但對父親一生矢志鴨肉世襲基業，自己卻無法克紹其裘，一直耿耿於懷。\r\n終於在民國40年，由年方16之子，自行創業，秉承父志，創立原味鴨肉飯又稱「回鄉飯」，原味燉鴨湯又稱「濃郁湯」，傳為地方美談，成為北港知名美食。', '上午11點~晚上7點', '651台灣雲林縣北港鎮中山路98號', 'certified', '23.566332565005435', '120.30442357063293', '5', 0, 42, 1, '2014-07-12 19:01:18', '2014-07-13 17:06:26'),
(16, 1, '圓環紅燒青蛙', '圓環紅燒青蛙', '', '651台灣雲林縣北港鎮文化路42-2號', 'certified', '23.56855872416975', '120.30155628919601', '0', 0, 5, 1, '2014-07-12 19:06:41', '2014-07-12 19:41:22'),
(17, 1, '北港一郎', '北港一郎', '', '651台灣雲林縣北港鎮仁和路1號', 'certified', '23.56862141501908', '120.3049385547638', '5', 0, 4, 1, '2014-07-12 19:08:29', '2014-07-12 22:48:25'),
(18, 1, '老擔煎盤粿', '老擔煎盤粿', '', '651台灣雲林縣北港鎮文昌路95號', 'certified', '23.574678930841205', '120.30001536011696', '4', 0, 3, 1, '2014-07-12 19:12:45', '2014-07-13 08:27:25'),
(19, 2, '鴨肉麵', '鴨肉麵', '10:00-18:00', '651台灣雲林縣北港鎮公民路115-129號', 'certified', '23.57053654458464', '120.30224025249481', '3', 1, 7, 1, '2014-07-12 22:26:58', '2014-07-12 23:01:08'),
(20, 3, '公園旁巷口早餐店', '平價早餐\r\n蛋餅、水煎包為推薦選項！', '', '651台灣雲林縣北港鎮北辰路2號', 'certified', '23.575367267231233', '120.30255675315857', '0', 0, 4, 1, '2014-07-12 23:06:52', '2014-07-13 08:27:36');

-- --------------------------------------------------------

--
-- 資料表結構 `unit_advices`
--

CREATE TABLE IF NOT EXISTS `unit_advices` (
`id` int(11) unsigned NOT NULL,
  `unit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `is_read` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 資料表的匯出資料 `unit_advices`
--

INSERT INTO `unit_advices` (`id`, `unit_id`, `user_id`, `message`, `ip`, `is_enabled`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 11, 3, '建議刪除景點ID: 11', '111.246.148.173', 1, 0, '2014-07-12 22:55:25', '2014-07-12 22:55:25');

-- --------------------------------------------------------

--
-- 資料表結構 `unit_comments`
--

CREATE TABLE IF NOT EXISTS `unit_comments` (
`id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `is_sync` int(11) NOT NULL DEFAULT '0',
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 資料表的匯出資料 `unit_comments`
--

INSERT INTO `unit_comments` (`id`, `user_id`, `unit_id`, `message`, `is_sync`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'fdsfsdfsdfsdf', 1, 0, '2014-07-12 13:06:40', '2014-07-12 13:06:44'),
(2, 2, 19, '去北港一定要吃這家!!', 1, 1, '2014-07-12 22:29:32', '2014-07-12 22:29:32');

-- --------------------------------------------------------

--
-- 資料表結構 `unit_pictures`
--

CREATE TABLE IF NOT EXISTS `unit_pictures` (
`id` int(11) unsigned NOT NULL,
  `unit_id` int(11) NOT NULL,
  `file_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- 資料表的匯出資料 `unit_pictures`
--

INSERT INTO `unit_pictures` (`id`, `unit_id`, `file_name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 15, '27265_53c1199617d7a.jpg', 1, '2014-07-12 19:18:42', '2014-07-12 19:18:46'),
(2, 15, '25388_53c119e3d3f0a.jpg', 1, '2014-07-12 19:19:59', '2014-07-12 19:20:04'),
(3, 15, '15242_53c119e77fc33.jpg', 1, '2014-07-12 19:20:04', '2014-07-12 19:20:07'),
(4, 17, '11709_53c11a8b9a395.jpg', 1, '2014-07-12 19:22:49', '2014-07-12 19:22:51'),
(5, 17, '2819_53c11a8f4e1a8.jpg', 1, '2014-07-12 19:22:52', '2014-07-12 19:22:55'),
(6, 1, '10605_53c11d4b7eb31.jpg', 1, '2014-07-12 19:34:31', '2014-07-12 19:34:45'),
(7, 1, '9779_53c11d58c2061.jpg', 1, '2014-07-12 19:34:45', '2014-07-12 19:35:00'),
(8, 1, '16737_53c11d80edcc3.jpg', 1, '2014-07-12 19:35:24', '2014-07-12 19:35:38'),
(9, 1, '16711_53c11d8e448cc.jpg', 1, '2014-07-12 19:35:38', '2014-07-12 19:35:50');

-- --------------------------------------------------------

--
-- 資料表結構 `unit_scores`
--

CREATE TABLE IF NOT EXISTS `unit_scores` (
`id` int(11) unsigned NOT NULL,
  `unit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- 資料表的匯出資料 `unit_scores`
--

INSERT INTO `unit_scores` (`id`, `unit_id`, `user_id`, `value`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '5', 1, '2014-07-12 12:21:36', '2014-07-12 12:21:36'),
(2, 11, 1, '5', 1, '2014-07-12 12:21:59', '2014-07-12 12:21:59'),
(3, 2, 1, '4', 1, '2014-07-12 13:00:17', '2014-07-12 13:00:17'),
(4, 13, 1, '5', 1, '2014-07-12 18:57:28', '2014-07-12 18:57:28'),
(5, 15, 1, '5', 1, '2014-07-12 19:41:17', '2014-07-12 19:41:17'),
(6, 18, 1, '4', 1, '2014-07-12 19:41:32', '2014-07-12 19:41:32'),
(7, 14, 1, '5', 1, '2014-07-12 19:41:38', '2014-07-12 19:41:38'),
(8, 17, 1, '5', 1, '2014-07-12 19:41:51', '2014-07-12 19:41:51'),
(9, 7, 2, '1', 1, '2014-07-12 22:18:49', '2014-07-12 22:18:49'),
(10, 9, 2, '1', 1, '2014-07-12 22:19:36', '2014-07-12 22:19:36'),
(11, 7, 1, '4', 1, '2014-07-12 22:20:21', '2014-07-12 22:20:21'),
(12, 19, 1, '3', 1, '2014-07-12 22:28:57', '2014-07-12 22:28:57'),
(13, 11, 3, '5', 1, '2014-07-12 22:55:22', '2014-07-12 22:55:22');

-- --------------------------------------------------------

--
-- 資料表結構 `unit_tags`
--

CREATE TABLE IF NOT EXISTS `unit_tags` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- 資料表的匯出資料 `unit_tags`
--

INSERT INTO `unit_tags` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, '名勝古蹟', 1, '2014-07-12 11:29:49', '2014-07-12 11:29:49'),
(2, '交通資訊', 1, '2014-07-12 11:37:07', '2014-07-12 11:37:07'),
(3, '學術單位', 1, '2014-07-12 11:42:35', '2014-07-12 11:42:35'),
(4, '美食小吃', 1, '2014-07-12 18:55:51', '2014-07-12 18:55:51'),
(5, '必推薦', 1, '2014-07-12 18:56:06', '2014-07-12 18:56:06'),
(6, '夜間消夜', 1, '2014-07-12 19:10:25', '2014-07-12 19:10:25'),
(7, '午後小吃', 1, '2014-07-12 19:12:57', '2014-07-12 19:12:57'),
(8, '早餐美食', 1, '2014-07-12 19:13:13', '2014-07-12 19:13:13');

-- --------------------------------------------------------

--
-- 資料表結構 `unit_tag_mappings`
--

CREATE TABLE IF NOT EXISTS `unit_tag_mappings` (
`id` int(11) unsigned NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_tag_id` int(11) NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- 資料表的匯出資料 `unit_tag_mappings`
--

INSERT INTO `unit_tag_mappings` (`id`, `unit_id`, `unit_tag_id`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2014-07-12 11:30:01', '2014-07-12 11:30:01'),
(2, 2, 1, 1, '2014-07-12 11:30:58', '2014-07-12 11:30:58'),
(3, 3, 1, 1, '2014-07-12 11:31:55', '2014-07-12 11:31:55'),
(4, 4, 1, 1, '2014-07-12 11:33:11', '2014-07-12 11:33:11'),
(5, 5, 2, 1, '2014-07-12 11:37:25', '2014-07-12 11:37:25'),
(6, 6, 2, 1, '2014-07-12 11:37:41', '2014-07-12 11:37:41'),
(7, 7, 2, 1, '2014-07-12 11:38:19', '2014-07-12 11:38:19'),
(8, 8, 3, 1, '2014-07-12 11:42:55', '2014-07-12 11:42:55'),
(9, 9, 3, 1, '2014-07-12 11:43:20', '2014-07-12 11:43:20'),
(10, 10, 3, 1, '2014-07-12 11:43:37', '2014-07-12 11:43:37'),
(11, 11, 3, 1, '2014-07-12 11:52:11', '2014-07-12 11:52:11'),
(12, 12, 3, 1, '2014-07-12 11:54:21', '2014-07-12 11:54:21'),
(13, 13, 4, 1, '2014-07-12 18:56:46', '2014-07-12 18:56:46'),
(14, 13, 5, 1, '2014-07-12 18:56:47', '2014-07-12 18:56:47'),
(15, 14, 4, 1, '2014-07-12 18:58:43', '2014-07-12 18:58:43'),
(16, 14, 5, 1, '2014-07-12 18:58:43', '2014-07-12 18:58:43'),
(17, 15, 4, 1, '2014-07-12 19:01:18', '2014-07-12 19:01:18'),
(18, 15, 5, 1, '2014-07-12 19:01:18', '2014-07-12 19:01:18'),
(19, 16, 4, 1, '2014-07-12 19:06:41', '2014-07-12 19:06:41'),
(20, 17, 4, 1, '2014-07-12 19:08:29', '2014-07-12 19:08:29'),
(21, 17, 5, 1, '2014-07-12 19:08:29', '2014-07-12 19:08:29'),
(22, 17, 6, 1, '2014-07-12 19:10:33', '2014-07-12 19:10:33'),
(23, 18, 4, 1, '2014-07-12 19:12:45', '2014-07-12 19:12:45'),
(24, 18, 5, 1, '2014-07-12 19:12:45', '2014-07-12 19:12:45'),
(25, 13, 7, 1, '2014-07-12 19:13:25', '2014-07-12 19:13:25'),
(26, 15, 7, 1, '2014-07-12 19:20:16', '2014-07-12 19:20:16'),
(27, 19, 4, 1, '2014-07-12 22:26:58', '2014-07-12 22:26:58'),
(28, 20, 8, 1, '2014-07-12 23:06:52', '2014-07-12 23:06:52');

-- --------------------------------------------------------

--
-- 資料表結構 `unit_views`
--

CREATE TABLE IF NOT EXISTS `unit_views` (
`id` int(11) unsigned NOT NULL,
  `unit_id` int(11) NOT NULL,
  `latitude` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `heading` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `pitch` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `zoom` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- 資料表的匯出資料 `unit_views`
--

INSERT INTO `unit_views` (`id`, `unit_id`, `latitude`, `longitude`, `heading`, `pitch`, `zoom`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 1, '23.567658', '120.30463899999995', '1.6561260516231198', '10.202386314656687', '1.6500000000000001', 1, '2014-07-12 11:28:17', '2014-07-12 11:29:13'),
(2, 3, '23.580793', '120.29853700000001', '69.97083248259513', '14.394815599321714', '1.32', 1, '2014-07-12 11:33:57', '2014-07-12 11:34:19'),
(3, 2, '23.567695', '120.30298900000003', '-82.14278284132575', '2.4231205776622153', '1.32', 1, '2014-07-12 11:35:41', '2014-07-12 11:36:16'),
(4, 5, '23.570061', '120.30070699999999', '-105.7760992469243', '1.6156415053571849', '0.66', 1, '2014-07-12 11:39:05', '2014-07-12 11:39:05'),
(5, 6, '23.570548', '120.30228', '-84.88316240797596', '8.510676590975171', '0.33', 1, '2014-07-12 11:40:03', '2014-07-12 11:40:53'),
(6, 7, '23.571582', '120.30000100000007', '-99.28378449051696', '16.579136430314914', '1.32', 1, '2014-07-12 11:41:19', '2014-07-12 11:42:09'),
(7, 8, '23.573634', '120.29543000000001', '30.198601889328508', '4.610792199660204', '1.32', 1, '2014-07-12 11:47:03', '2014-07-12 11:47:52'),
(8, 9, '23.565588', '120.29900399999997', '24.961870036629875', '8.798206763412592', '1.9800000000000002', 1, '2014-07-12 11:48:23', '2014-07-12 11:49:07'),
(9, 10, '23.566692', '120.30109700000003', '184.66138362171048', '6.346644445989934', '0.99', 1, '2014-07-12 11:49:45', '2014-07-12 11:51:01'),
(10, 11, '23.577252', '120.30302800000004', '-5.250380093254404', '0.9992508289876944', '1.32', 1, '2014-07-12 11:52:58', '2014-07-12 11:54:26'),
(11, 12, '23.577144', '120.30442500000004', '4.9096704029583575', '11.437594301646172', '0.66', 1, '2014-07-12 11:54:47', '2014-07-12 11:55:46'),
(12, 13, '23.573462', '120.297144', '106.93711541348424', '-2.39315370250415', '1.6500000000000001', 1, '2014-07-12 18:57:09', '2014-07-12 18:58:06'),
(13, 14, '23.565276', '120.304213', '-50.974053691376504', '-6.1491359622423145', '1.32', 1, '2014-07-12 18:59:12', '2014-07-12 18:59:40'),
(14, 15, '23.566504', '120.30444299999999', '144.34716354726572', '-2.9568211217343054', '1.9800000000000002', 1, '2014-07-12 19:02:40', '2014-07-12 19:05:23'),
(15, 16, '23.56861', '120.30158699999993', '138.49744551389176', '0.16132863979434112', '1.9800000000000002', 1, '2014-07-12 19:09:33', '2014-07-12 19:10:01'),
(16, 18, '23.574788', '120.299984', '32.317659516753224', '-7.648297338978541', '0.99', 1, '2014-07-12 19:13:53', '2014-07-12 19:13:53'),
(17, 19, '23.570631', '120.30231900000001', '-75.2349537629129', '-7.312847975736897', '2.64', 1, '2014-07-12 22:27:53', '2014-07-12 22:28:08'),
(18, 20, '23.575271', '120.30260900000007', '104.58446374995344', '-3.515498308890892', '0.66', 1, '2014-07-13 08:26:15', '2014-07-13 08:26:31');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) unsigned NOT NULL,
  `uid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `register_from` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`id`, `uid`, `name`, `email`, `register_from`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, '100000100541088', '吳政賢', 'comdan66@gmail.com', 'facebook', 1, '2014-07-12 11:26:01', '2014-07-12 11:26:01'),
(2, '100000117171015', '李永裕', 'yungyu405728@gmail.com', 'facebook', 1, '2014-07-12 22:17:33', '2014-07-12 22:17:33'),
(3, '1331304180', 'Jason Lin', 'jknight1224@hotmail.com', 'facebook', 1, '2014-07-12 22:46:29', '2014-07-12 22:46:29'),
(4, '100006789307672', '吳政賢', 'oa@fashionguide.com.tw', 'facebook', 1, '2014-07-13 16:11:32', '2014-07-13 16:11:32');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `errors`
--
ALTER TABLE `errors`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `pageviews`
--
ALTER TABLE `pageviews`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `temp_pictures`
--
ALTER TABLE `temp_pictures`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `units`
--
ALTER TABLE `units`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `unit_advices`
--
ALTER TABLE `unit_advices`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `unit_comments`
--
ALTER TABLE `unit_comments`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `unit_pictures`
--
ALTER TABLE `unit_pictures`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `unit_scores`
--
ALTER TABLE `unit_scores`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `unit_tags`
--
ALTER TABLE `unit_tags`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `unit_tag_mappings`
--
ALTER TABLE `unit_tag_mappings`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `unit_views`
--
ALTER TABLE `unit_views`
 ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `errors`
--
ALTER TABLE `errors`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `pageviews`
--
ALTER TABLE `pageviews`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- 使用資料表 AUTO_INCREMENT `temp_pictures`
--
ALTER TABLE `temp_pictures`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- 使用資料表 AUTO_INCREMENT `units`
--
ALTER TABLE `units`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- 使用資料表 AUTO_INCREMENT `unit_advices`
--
ALTER TABLE `unit_advices`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `unit_comments`
--
ALTER TABLE `unit_comments`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `unit_pictures`
--
ALTER TABLE `unit_pictures`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- 使用資料表 AUTO_INCREMENT `unit_scores`
--
ALTER TABLE `unit_scores`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- 使用資料表 AUTO_INCREMENT `unit_tags`
--
ALTER TABLE `unit_tags`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- 使用資料表 AUTO_INCREMENT `unit_tag_mappings`
--
ALTER TABLE `unit_tag_mappings`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- 使用資料表 AUTO_INCREMENT `unit_views`
--
ALTER TABLE `unit_views`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
