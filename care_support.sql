-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-11-22 14:25:33
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `care_support`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `ケア管理`
--

CREATE TABLE `ケア管理` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `care_date` date NOT NULL,
  `care_type` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `患者`
--

CREATE TABLE `患者` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `patient_birthday` date NOT NULL,
  `gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `服薬管理`
--

CREATE TABLE `服薬管理` (
  `medication_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `medication_name` varchar(100) NOT NULL,
  `medication_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `職員`
--

CREATE TABLE `職員` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `staff_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `ケア管理`
--
ALTER TABLE `ケア管理`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- テーブルのインデックス `患者`
--
ALTER TABLE `患者`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `patient_name` (`patient_name`);

--
-- テーブルのインデックス `服薬管理`
--
ALTER TABLE `服薬管理`
  ADD PRIMARY KEY (`medication_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- テーブルのインデックス `職員`
--
ALTER TABLE `職員`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `staff_name` (`staff_name`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `ケア管理`
--
ALTER TABLE `ケア管理`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `患者`
--
ALTER TABLE `患者`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `服薬管理`
--
ALTER TABLE `服薬管理`
  MODIFY `medication_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `職員`
--
ALTER TABLE `職員`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `ケア管理`
--
ALTER TABLE `ケア管理`
  ADD CONSTRAINT `ケア管理_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `患者` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ケア管理_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `職員` (`staff_id`) ON DELETE CASCADE;

--
-- テーブルの制約 `服薬管理`
--
ALTER TABLE `服薬管理`
  ADD CONSTRAINT `服薬管理_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `患者` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `服薬管理_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `職員` (`staff_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
