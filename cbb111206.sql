-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-07-07 06:06:16
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `cbb111206`
--

-- --------------------------------------------------------

--
-- 資料表結構 `accounts`
--

CREATE TABLE `accounts` (
  `member_id` int(11) NOT NULL,
  `account` varchar(255) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `accounts`
--

INSERT INTO `accounts` (`member_id`, `account`, `password`) VALUES
(1, 'root', 'root'),
(2, 'Jurass', '3929'),
(3, 'Jac', 'ok'),
(4, 'David', 'awaehaeheh'),
(5, 'Huffman@gmail.com', 'Tree');

-- --------------------------------------------------------

--
-- 資料表結構 `playlists`
--

CREATE TABLE `playlists` (
  `playlist_id` int(11) NOT NULL,
  `playlist_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `playlists`
--

INSERT INTO `playlists` (`playlist_id`, `playlist_name`, `user_id`) VALUES
(1, 'Coldplay合輯', 1),
(2, 'Charlie Puth合輯', 1),
(3, 'Ed sheeran合輯', 1),
(11, 'Coldplay合輯', 2);

-- --------------------------------------------------------

--
-- 資料表結構 `playlist_songs`
--

CREATE TABLE `playlist_songs` (
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `singers`
--

CREATE TABLE `singers` (
  `singer_id` int(11) NOT NULL,
  `singer_name` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `singers`
--

INSERT INTO `singers` (`singer_id`, `singer_name`, `create_time`) VALUES
(1, 'Coldplay', '2024-05-27 01:50:37'),
(2, 'Ed sheeran', '2024-05-27 01:50:37'),
(3, 'Charlie Puth', '2024-05-27 01:51:12'),
(4, 'Justin Bieber', '2024-05-27 01:53:33'),
(5, 'Sasha Alex Sloan', '2024-05-27 02:22:01'),
(6, 'Lauv', '2024-05-27 02:23:01');

-- --------------------------------------------------------

--
-- 資料表結構 `songs`
--

CREATE TABLE `songs` (
  `songId` int(11) NOT NULL,
  `songName` varchar(255) NOT NULL,
  `singer_id` int(11) DEFAULT NULL,
  `coverImage` varchar(255) DEFAULT NULL,
  `songFile` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`member_id`);

--
-- 資料表索引 `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`playlist_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `playlist_songs`
--
ALTER TABLE `playlist_songs`
  ADD PRIMARY KEY (`playlist_id`,`song_id`),
  ADD KEY `fk_song_id` (`song_id`);

--
-- 資料表索引 `singers`
--
ALTER TABLE `singers`
  ADD PRIMARY KEY (`singer_id`);

--
-- 資料表索引 `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`songId`),
  ADD KEY `fk_singer` (`singer_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `accounts`
--
ALTER TABLE `accounts`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `playlists`
--
ALTER TABLE `playlists`
  MODIFY `playlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `singers`
--
ALTER TABLE `singers`
  MODIFY `singer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `songs`
--
ALTER TABLE `songs`
  MODIFY `songId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`member_id`);

--
-- 資料表的限制式 `playlist_songs`
--
ALTER TABLE `playlist_songs`
  ADD CONSTRAINT `fk_playlist_id` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`playlist_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_song_id` FOREIGN KEY (`song_id`) REFERENCES `songs` (`songId`) ON DELETE CASCADE;

--
-- 資料表的限制式 `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `fk_singer` FOREIGN KEY (`singer_id`) REFERENCES `singers` (`singer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
