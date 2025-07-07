-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-07-04 17:57:11
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

--
-- 傾印資料表的資料 `playlist_songs`
--

INSERT INTO `playlist_songs` (`playlist_id`, `song_id`, `position`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 5, 6),
(1, 6, 6),
(1, 8, 7),
(2, 18, 2),
(2, 19, 1),
(3, 13, 2),
(3, 14, 3),
(3, 17, 2),
(11, 1, 5),
(11, 2, 4),
(11, 3, 1),
(11, 5, 3),
(11, 6, 6),
(11, 7, 7),
(11, 8, 8);

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
-- 傾印資料表的資料 `songs`
--

INSERT INTO `songs` (`songId`, `songName`, `singer_id`, `coverImage`, `songFile`, `created_at`) VALUES
(1, 'Viva La Vida', 1, 'uploads/Viva-La-Vida-coldplay.jpeg', 'songs/Coldplay - Viva La Vida.mp3', '2024-04-22 15:50:21'),
(2, 'Yellow', 1, 'uploads/Yellow-coldplay.jpg', 'songs/Coldplay - Yellow (Official Video).mp3', '2024-04-23 13:28:22'),
(3, 'The scientist', 1, 'uploads/The scientist-coldplay.jpg', 'songs/Coldplay - The Scientist (Official 4K Video).mp3', '2024-04-23 13:30:01'),
(4, 'Hymn For The Weekend', 1, 'uploads/Hymn_for_the_Weekend-coldplay.jpg', 'songs/Coldplay - Hymn For The Weekend (Official Video).mp3', '2024-04-23 13:32:40'),
(5, 'Adventure Of A Lifetime', 1, 'uploads/Adventure Of A Lifetime-coldplay.jpg', 'songs/Coldplay - Adventure Of A Lifetime (Official Video).mp3', '2024-04-23 13:37:37'),
(6, 'Paradise', 1, 'uploads/Paradise-coldplay.jpg', 'songs/Coldplay - Paradise (Official Video).mp3', '2024-04-23 13:40:49'),
(7, 'A Sky Full Of Stars', 1, 'uploads/ASFOS-coldplay.jpg', 'songs/Coldplay - A Sky Full Of Stars (Official Video).mp3', '2024-04-23 13:43:28'),
(8, 'Higher Power', 1, 'uploads/Higher Power-coldplay.jpg', 'songs/Coldplay - Higher Power (Official Video).mp3', '2024-04-23 13:48:44'),
(9, 'In My Place', 1, 'uploads/In_My_Place-coldplay.jpg', 'songs/Coldplay - In My Place (Official Video).mp3', '2024-04-23 13:56:39'),
(10, 'Shape of You', 2, 'uploads/Shape Of You-Ed Sheeran.jpg', 'songs/Ed Sheeran - Shape of You [Official Video].mp3', '2024-04-23 13:59:36'),
(11, 'Perfect', 2, 'uploads/Perfect-Ed Sheeran.jpg', 'songs/Ed Sheeran - Perfect (Official Music Video).mp3', '2024-04-23 14:01:27'),
(12, 'I see fire', 2, 'uploads/I_See_Fire-Ed sheeran.jpg', 'songs/Ed Sheeran - I See Fire (Music Video).mp3', '2024-04-25 12:37:35'),
(13, 'What Do I Know', 2, 'uploads/What Do I Know-Ed sheeran.jpg', 'songs/Ed Sheeran - What Do I Know [Official Audio].mp3', '2024-04-25 12:41:07'),
(14, 'Thinking Out Loud', 2, 'uploads/Thinking Out Loud.jpg', 'songs/Ed Sheeran - Thinking Out Loud [Official Video].mp3', '2024-04-25 12:46:21'),
(15, 'Galway Girl', 2, 'uploads/Galway Girl.jpg', 'songs/Ed Sheeran - Galway Girl [Official Video].mp3', '2024-04-25 12:48:08'),
(16, 'Happier', 2, 'uploads/Happier-Ed Sheeran.jpg', 'songs/Ed Sheeran - Happier (Official Video).mp3', '2024-04-25 12:54:37'),
(17, 'Dive', 2, 'uploads/Dive-Ed Sheeran.jpg', 'songs/Ed Sheeran - Dive [Official Audio].mp3', '2024-05-03 10:08:12'),
(18, 'Light Switch', 3, 'uploads/Light_Switch-Charlie Puth.jpg', 'songs/Charlie Puth - Light Switch [Official Music Video].mp3', '2024-05-06 14:56:41'),
(19, 'That\'s Hilarious', 3, 'uploads/Thats_Hilarious-Charlie Puth.jpg', 'songs/Charlie Puth - Thats Hilarious [Official Video].mp3', '2024-05-08 15:16:48'),
(20, 'We Don\'t Talk Anymore', 3, 'uploads/We Dont Talk Anymore-Charlie Puth.jpg', 'songs/Charlie Puth - We Dont Talk Anymore (feat. Selena Gomez) [Official Video].mp3', '2024-05-26 15:20:02'),
(21, 'Charlie Be Quiet!', 3, 'uploads/Charlie Be Quiet!-Charlie Puth.jpg', 'songs/Charlie Puth - Charlie Be Quiet! (Official Audio).mp3', '2024-05-26 15:20:37'),
(22, 'How Long', 3, 'uploads/How_Long-Charlie_Puth.jpg', 'songs/Charlie Puth - How Long [Official Video].mp3', '2024-05-26 15:21:14'),
(23, 'One Call Away', 3, 'uploads/One Call Away-Charlie Puth.jpg', 'songs/Charlie Puth - One Call Away [Official Video].mp3', '2024-05-26 15:21:40'),
(24, 'The Way I Am', 3, 'uploads/The_Way_I_Am-Charlie Puth.jpg', 'songs/Charlie Puth - The Way I Am [Official Video].mp3', '2024-05-26 15:22:04'),
(25, 'Done For Me', 3, 'uploads/Done_for_Me-Charlie Puth.png', 'songs/Charlie Puth - Done For Me (feat. Kehlani) [Official Video].mp3', '2024-05-26 16:29:13'),
(26, 'Girlfriend', 3, 'uploads/Girlfriend-Charlie Puth.png', 'songs/Charlie Puth - Girlfriend [Official Video].mp3', '2024-05-26 16:30:23'),
(27, ' Love Yourself', 4, 'uploads/Love_Yourself-JustinBieber.png', 'songs/Justin Bieber - Love Yourself (Audio).mp3', '2024-05-26 16:32:29'),
(28, 'As Long As You Love Me', 4, 'uploads/As_Long_As_You_Love_Me-Justin Bieber.jpg', 'songs/Justin Bieber - As Long As You Love Me.mp3', '2024-05-26 16:34:30'),
(29, 'Ghost', 3, 'uploads/Ghost-Justin Bieber.jpg', 'songs/Justin Bieber - Ghost.mp3', '2024-05-26 16:35:35'),
(30, 'Off My Face', 4, 'uploads/Off My Face-Justin Bieber.jpg', 'uploads/Justin Bieber - Off My Face (Live from Paris).mp3', '2024-05-27 02:31:40'),
(31, 'Baby', 4, 'uploads/Baby-Justin Bieber.jpg', 'uploads/Justin Bieber - Baby ft. Ludacris.mp3', '2024-05-30 03:46:55'),
(32, 'Beauty And A Beat', 4, 'uploads/Beauty And A Beat-Justin Bieber.jpg', 'songs/Justin Bieber - Beauty And A Beat ft. Nicki Minaj (Official Audio).mp3', '2024-05-30 03:48:23'),
(33, 'Boyfriend', 4, 'uploads/Boyfriend-Justin Bieber.jpg', 'songs/Justin Bieber - Boyfriend (Official Audio).mp3', '2024-05-30 03:52:21'),
(34, 'Intentions', 4, 'uploads/Intentions-Justin Bieber.jpg', 'uploads/Justin Bieber - Intentions (Official Video (Short Version)) ft. Quavo.mp3', '2024-05-30 03:53:47'),
(35, 'Mistletoe', 4, 'uploads/Mistletoe-Justin Bieber.jpg', 'uploads/Justin Bieber - Mistletoe.mp3', '2024-05-30 03:55:44'),
(36, 'Peaches', 4, 'uploads/Peaches-Justin Bieber.png', 'uploads/Justin Bieber - Peaches ft. Daniel Caesar, Giveon.mp3', '2024-05-30 03:57:12'),
(37, 'Sorry', 4, 'uploads/Sorry-Justin Bieber.jpg', 'uploads/Justin Bieber - Sorry (Latino Remix - Audio) ft. J Balvin.mp3', '2024-05-30 03:59:52'),
(38, 'What Do You Mean', 4, 'uploads/What Do You Mean-Justin Bieber.jpg', 'uploads/Justin Bieber - What Do You Mean- (Lyric Video).mp3', '2024-05-30 04:02:57'),
(39, 'Stay', 4, 'uploads/Stay-Justin Bieber feat.The Mid LAROI.jpg', 'uploads/The Kid LAROI, Justin Bieber - STAY (Official Video).mp3', '2024-05-30 04:03:19'),
(40, 'Normal', 5, 'uploads/Normal-Sasha Sloan.jpg', 'uploads/Sasha Alex Sloan - Normal (Official Video).mp3', '2024-05-30 04:07:55'),
(41, 'Dancing With Your Ghost', 5, 'uploads/Dancing With Your Ghost-Sasha Sloan.jpg', 'uploads/Sasha Sloan - Dancing With Your Ghost (Lyric Video).mp3', '2024-05-30 04:10:59'),
(42, 'I Blame The World', 5, 'uploads/I Blame The World-Sasha Sloan.jpg', 'uploads/Sasha Alex Sloan - I Blame The World (Official Video).mp3', '2024-05-30 04:14:25'),
(43, 'High School Me', 5, 'uploads/High School Me-Sasha Sloan.jpg', 'uploads/Sasha Alex Sloan - High School Me (Lyric Video) (128 kbps).mp3', '2024-05-30 04:15:24'),
(44, 'Until It Happens To You', 5, 'uploads/Until It Happens To You-Sasha Sloan.jpg', 'uploads/Sasha Alex Sloan - Until It Happens To You (Lyric Video).mp3', '2024-05-30 04:17:51'),
(45, 'Hypochondriac', 5, 'uploads/Hypochondriac-Sasha Sloan.jpg', 'uploads/Sasha Alex Sloan - Hypochondriac (Lyric Video).mp3', '2024-05-30 04:18:47'),
(46, 'Someone You Hate', 5, 'uploads/Someone You Hate-Sasha sloan.jpg', 'uploads/Sasha Alex Sloan - Someone You Hate (Lyric Video).mp3', '2024-05-30 04:19:55'),
(47, 'Matter To You', 5, 'uploads/Matter To You-Sasha Sloan.jpg', 'uploads/Sasha Alex Sloan - Matter To You (Official Video).mp3', '2024-05-30 04:22:05'),
(48, 'The Only', 5, 'uploads/The Only-Sasha Sloan.jpg', 'uploads/Sasha Alex Sloan - The Only (Official Video).mp3', '2024-05-30 04:34:56'),
(49, 'House With No Mirrors', 5, 'uploads/House With No Mirrors-Sasha Sloan.jpg', 'uploads/Sasha Alex Sloan - House With No Mirrors (Official Video).mp3', '2024-05-30 04:35:42'),
(50, 'Never Not', 6, 'uploads/Never Not-Lauv.jpg', 'uploads/Lauv - Never Not (Lyric Video).mp3', '2024-05-30 04:38:21'),
(51, 'Steal The Show', 6, 'uploads/Steal_the_Show-Lauv.jpg', 'songs/Lauv - Steal The Show (From ElementalLyric Video).mp3', '2024-05-30 04:40:44'),
(52, 'I Like Me Better', 6, 'uploads/I Like Me Better-Lauv.jpg', 'uploads/Lauv - I Like Me Better [Official Video].mp3', '2024-05-30 04:41:54'),
(53, 'Paris in the Rain', 6, 'uploads/Paris in the Rain-Lauv.jpg', 'uploads/Lauv - Paris in the Rain [Official Video].mp3', '2024-05-30 04:43:18'),
(54, 'Mean It', 6, 'uploads/Mean It-Lauv.jpg', 'uploads/Lauv & LANY - Mean It [Official Video].mp3', '2024-05-30 04:47:20');

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
