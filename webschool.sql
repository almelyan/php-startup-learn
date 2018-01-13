-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 02, 2018 at 02:01 AM
-- Server version: 5.7.10-log
-- PHP Version: 5.6.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `ThumbnailUrl` varchar(500) DEFAULT NULL,
  `CoverUrl` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`ID`, `Name`, `ThumbnailUrl`, `CoverUrl`) VALUES
(1, 'ANKARA', 'images/T01.jpg', 'images/A02.jpg'),
(2, 'ISTANBUL', 'images/T02.jpg', 'images/A03.jpg'),
(3, 'IZMIR', 'images/T03.jpg', 'images/A01.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `SchoolID` int(11) NOT NULL,
  `RegistDate` date NOT NULL,
  `Accept` enum('N','A','R') NOT NULL DEFAULT 'N',
  `AcceptDate` date DEFAULT NULL,
  `Notes` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`ID`, `StudentID`, `SchoolID`, `RegistDate`, `Accept`, `AcceptDate`, `Notes`) VALUES
(8, 1, 22, '2018-01-02', 'A', '2018-01-02', 'Only one registration can Accept !');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `TownID` int(11) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Phone` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`ID`, `Name`, `TownID`, `Address`, `Phone`) VALUES
(1, 'KARATAŞ', 1, 'KARATAŞ MAH.İSTİKLAL CAD.NU.:10', '(312) 499 00 34'),
(2, 'ARALIK LİONS', 1, 'MALAZGİRT MAH. DİKMEN CAD. 1012.SOK NO:1', '(312) 476 59 50'),
(3, 'YASEMİN KARAKAYA', 1, 'Mustafa Kemal Mah. Eskişehir Yolu 7. Km ÇANKAYA', '(312) 219 51 03'),
(4, 'KARAPÜRÇEK İMAM HATİP', 2, 'KARAPÜRÇEK MAH.453.SOKAK NO:2 ALTINDAĞ/ANKARA', '(312) 375 12 76'),
(5, 'ABDULLAH TOKUR', 2, 'Kareli sk. no:37 Altındağ/ankara', '(312) 348 04 61'),
(6, 'ALİ ERSOY', 2, 'celal Esat Arseven cd No:2 SİTELER', '(312) 348 72 58'),
(7, 'MİMAR SİNAN', 3, 'DEMETGÜL MAHALLESİ 412.SOKAK NO:54 DEMETEVLER/ANKARA', '(312) 336 09 70'),
(8, 'ABAY', 3, 'KARDELEN MAH.2089. SOKAK NO:1 YENİMAHALLE/ANKARA', '(312) 255 82 96'),
(9, 'AHMET HAMDİ TANPINAR', 3, 'Ergazi Mah. 1820.Cad(11.Cad) Batıkent/Ankara', '(312) 255 14 05'),
(10, 'KEÇİÖREN YUNUS EMRE', 4, 'KUŞÇAĞIZ MAHALLESİ GAZELLER CADDESİ ANKARA TERAS TOKİ KONUTLARI KEÇİÖREN/ANKARA', '(312) 380 42 40'),
(11, 'ABDULHAKİM ARVASİ', 4, 'Karşıyaka Mah. 19 Mayıs Cad.No:6 Bağlum/Keçiören', '(312) 329 64 66'),
(12, 'AŞIK VEYSEL', 4, 'ATAPARK MAH.ELMALI CAD NO:10', '(312) 355 57 17'),
(13, 'MMEHMET ÇEKİÇ', 5, 'AŞIKVEYSEL MAHALLESİ SÜLEYMAN AYTEN CAD.NO:38 MAMAK-ANKARA', '(312) 365 55 33'),
(14, 'AÇIKALIN', 5, 'Fahri Korutürk mah.Nato Yolu Cad.686.Sok.No.9 Mamak-ANKARA', '(312) 391 70 21'),
(15, 'ALİ ŞİR NEVAİ', 5, 'DURALİ ALIÇ MAHALLESİ ŞEHİTLER CADDESİ NO:299 MAMAK/ANKARA', '(312) 390 57 54'),
(16, 'MEHMET AKİF İMAM HATİP', 6, '19 Mayıs Mah. Şemsettin Günaltay Cd. Gürsoyluı Sk. No:23', '(216) 356 04 71'),
(17, 'BAHARİYE', 6, 'BAHARİYE CAD. KUZUKESTANE SK.N0:3', '(216) 414 22 86'),
(18, 'FAİK REŞİT UNAT', 6, 'FAHRETTİN KERİM GÖKAY CAD.NO:64 GÖZTEPE-KADIKÖY-İST', '(216) 566 92 74'),
(19, 'İMDAT VAKFI DUMLUPINAR', 7, 'Feyzullah Mah.Serap Cad. No:60', '(216) 441 96 19'),
(20, 'ADNAN KAHVECİ', 7, 'HANIMELİ CAD.NO:21 ZÜMRÜTEVLER MALTEPE-İSTANBUL', '(216) 370 98 17'),
(21, 'ALTAY ÇEŞME', 7, 'Altay Çeşme Mahallesi Bomaç Sokak No:21 Maltepe/İSTANBUL', '(216) 352 32 85'),
(22, 'MAHMUT ŞEVKETPAŞA', 8, 'M.ŞEVKET PAŞA KÖYÜ OKUL SOK.NO:3', '(216) 319 42 75'),
(23, 'AKBABA İSMAİL ÖZSEÇKİN', 8, 'FENER CAD NO:56 AKBABA-BEYKOZ/İSTANBUL', '(216) 320 44 20'),
(24, 'ANADOLUHİSARI', 8, 'GÖZTEPE MAH. EZGİ SOKAK NO:8 BEYKOZ İSTANBUL', '(216) 332 02 59'),
(25, 'İSA YUSUF ALPTEKİN', 9, 'ORHANGAZİ MAH. CUMHURİYET CAD. LAD,N SK NO 41 PENDİK', '(216) 493 52 21'),
(26, 'ABDULLAH ACAR', 9, 'ESENYALI MAH.İSTİKLAL CAD.CEM SOK:NO:7/15', '(216) 494 48 87'),
(27, 'ADİL ERDEM BAYAZIT', 9, 'KAVAKPINAR MAHALLESİ VATAN CADDESİ NO:5 PENDİK/İSTANBUL', '(216) 397 03 31'),
(28, 'ALİ BAYIRLAR', 10, 'Yalı Mah.Mithatpaşa cad. No:469/C', '(232) 234 21 32'),
(29, 'GÜZELBAHÇE VALİ KAZIM PAŞA', 10, 'Atatürk Mh. 555 Sk.No:7 Güzelbahçe/İzmir', '(232) 234 26 08'),
(30, 'HAKKI OĞUZ TABAOĞLU', 10, 'KAHRAMANDERE MAH. 807 SOK NO:1', '(232) 234 72 72'),
(31, 'GÖRECE ŞEHİT MUSTAFA MUTLU', 11, 'Görece Cumhuriyet Mahallesi Nihat Sertel Caddesi no:115', '(232) 781 12 14'),
(32, 'ALTINTEPE', 11, 'JANDARMA SOK.N:66 MENDERES İZMİR', '(232) 782 46 36'),
(33, 'BAYRAK', 11, 'KEMALPAŞA MAH 113SOK NO.2 MENDERES İZMİR', '(232) 782 70 10');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `ID` int(11) NOT NULL,
  `TCNo` varchar(15) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `BirthDate` date NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`ID`, `TCNo`, `FirstName`, `LastName`, `BirthDate`, `Address`, `Phone`, `Email`) VALUES
(1, '123456', 'Mohammed', 'Salem', '1991-12-01', 'Test Address', '2586652365', 'mohammed@gmail.com'),
(2, '654321', 'Ahmed', 'Ali', '1990-10-26', 'Test Address', '2568590878', 'ahmed_ali@gmail.com'),
(5, '589654', 'Test', 'Test', '1990-01-01', 'Test', '3214569875', 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `town`
--

CREATE TABLE `town` (
  `ID` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `CityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `town`
--

INSERT INTO `town` (`ID`, `Name`, `CityID`) VALUES
(1, 'Çankaya', 1),
(2, 'Altındağ', 1),
(3, 'Yenimahalle', 1),
(4, 'Keçiören', 1),
(5, 'Mamak', 1),
(6, 'Kadıköy', 2),
(7, 'Maltepe', 2),
(8, 'Beykoz', 2),
(9, 'Pendik', 2),
(10, 'Güzelbahçe', 3),
(11, 'Menderes', 3),
(12, 'Bayındır', 3),
(13, 'Dikili', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Account` enum('A','U') NOT NULL DEFAULT 'U',
  `StudentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `UserName`, `Password`, `Email`, `Account`, `StudentID`) VALUES
(1, 'Website Admin', '123456', 'admin@email.com', 'A', NULL),
(4, 'Hussam Almelyan', '123456', 'hosa1991osm@gmail.com', 'U', 1),
(5, 'Ahmed Ali', '123456', 'ahmed_ali@gmail.com', 'U', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `TCNo` (`TCNo`);

--
-- Indexes for table `town`
--
ALTER TABLE `town`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `town`
--
ALTER TABLE `town`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
