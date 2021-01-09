-- phpMyAdmin SQL Dump
-- version 3.5.FORPSI
-- http://www.phpmyadmin.net
--
-- Počítač: 185.129.138.24
-- Vygenerováno: Úte 05. led 2021, 16:16
-- Verze MySQL: 5.6.42-84.2-log
-- Verze PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

USE `f114632`;

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_CATEGORIES`
--

CREATE TABLE IF NOT EXISTS `2020_CATEGORIES` (
  `CATEGORY` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`CATEGORY`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=9 ;

--
-- Vypisuji data pro tabulku `2020_CATEGORIES`
--

INSERT INTO `2020_CATEGORIES` (`CATEGORY`, `CATEGORY_NAME`) VALUES
(1, 'ÚVOD'),
(2, '1. třída'),
(3, '2. třída'),
(4, '3. třída'),
(5, '4. třída'),
(6, '5. třída'),
(7, 'DOKUMENTY'),
(8, 'JÍDELNA');

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_EMPLOYEES`
--

CREATE TABLE IF NOT EXISTS `2020_EMPLOYEES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `POSITION` int(11) NOT NULL COMMENT 'CK -> 2020_Positions',
  `EMAIL` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `DESCRIPTION` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `POSITION` (`POSITION`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=95 ;

--
-- Vypisuji data pro tabulku `2020_EMPLOYEES`
--

INSERT INTO `2020_EMPLOYEES` (`ID`, `NAME`, `POSITION`, `EMAIL`, `DESCRIPTION`) VALUES
(1, 'Ředitel', 1, 'reditel@domain.com', 'Ředitel školy'),
(4, 'Kuchař', 2, 'kuchar@domain.com', 'Kuchař'),
(5, 'Učitel', 3, 'ucitel@domain.com', 'třídní učitelka 1. ročníku'),
(13, 'Vychovatelka', 4, 'vychovatel@domain.com', 'vedoucí vychovatelka ŠD'),
(14, 'Zřizovatel', 5, 'zrizovatel@domain.com', ''),
(17, 'IT správce', 6, 'ITsprávce@domain.com', 'správce IT');

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_EVENTS`
--

CREATE TABLE IF NOT EXISTS `2020_EVENTS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TYPE` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `START` datetime NOT NULL,
  `END` datetime DEFAULT NULL,
  `EVENT_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `EVENT_ID` (`EVENT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_EVENTS_TYPE`
--

CREATE TABLE IF NOT EXISTS `2020_EVENTS_TYPE` (
  `EVENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `EVENT_NAME` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`EVENT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `2020_EVENTS_TYPE`
--

INSERT INTO `2020_EVENTS_TYPE` (`EVENT_ID`, `EVENT_NAME`) VALUES
(2, 'Prázdniny'),
(3, 'Třídní schůzky'),
(4, 'Zápis');

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_FOTOGALERY`
--

CREATE TABLE IF NOT EXISTS `2020_FOTOGALERY` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROUTE` varchar(256) CHARACTER SET utf8 NOT NULL,
  `POSITION` int(1) NOT NULL,
  `CATEGORY_ID` int(11) NOT NULL DEFAULT '32',
  PRIMARY KEY (`ID`),
  KEY `kategorie` (`CATEGORY_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=1076 ;

--
-- Vypisuji data pro tabulku `2020_FOTOGALERY`
--

INSERT INTO `2020_FOTOGALERY` (`ID`, `ROUTE`, `POSITION`, `CATEGORY_ID`) VALUES
(1075, 'testImg.jpg', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_FOTOGALERY_CATEGORY`
--

CREATE TABLE IF NOT EXISTS `2020_FOTOGALERY_CATEGORY` (
  `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`CATEGORY_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `2020_FOTOGALERY_CATEGORY`
--

INSERT INTO `2020_FOTOGALERY_CATEGORY` (`CATEGORY_ID`, `NAME`) VALUES
(2, 'Testovací fotogalerie');

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_MENU`
--

CREATE TABLE IF NOT EXISTS `2020_MENU` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DAY` varchar(50) NOT NULL,
  `SOUP` varchar(255) NOT NULL,
  `MAIN_MEAL` varchar(255) NOT NULL,
  `DESSERT` varchar(255) NOT NULL,
  `DRINKS` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `2020_MENU`
--

INSERT INTO `2020_MENU` (`ID`, `DAY`, `SOUP`, `MAIN_MEAL`, `DESSERT`, `DRINKS`) VALUES
(1, 'Pondělí', 'Kroupová', 'Ovocné knedlíky,\r\ntvaroh', '', 'Mléko'),
(2, 'Úterý', 'Luštěninová', ' Rybí prsty, brambory\r\n    \r\n        ', 'Ovocný kompot', 'Mléko'),
(3, 'Středa', ' Krupicová', 'Krůtí směs,rýže', '', 'Džus'),
(4, 'Čtvrtek', 'Zelná', 'Zapečené těstoviny,\r\nokurka', '', 'Mléko'),
(5, 'Pátek', 'Vývar', 'Rajská omáčka,\r\nmasové kuličky,\r\nknedlík', '', 'Sirup');

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_NOTIFICATION`
--

CREATE TABLE IF NOT EXISTS `2020_NOTIFICATION` (
  `ID_NOTICE` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `DESCRIPTION` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `CREATED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `BORDER_COLOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT 'black',
  `FOUNDER` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT 'anonym',
  `CATEGORY` int(11) NOT NULL,
  PRIMARY KEY (`ID_NOTICE`),
  KEY `CATEGORY` (`CATEGORY`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=513 ;

--
-- Vypisuji data pro tabulku `2020_NOTIFICATION`
--

INSERT INTO `2020_NOTIFICATION` (`ID_NOTICE`, `TITLE`, `DESCRIPTION`, `CREATED`, `BORDER_COLOR`, `FOUNDER`, `CATEGORY`) VALUES
(510, 'Testovací příspěvek', '<p>Test testovacího příspěvku</p>', '2021-01-05 14:01:07', '#000000', 'Stepanka Srbova', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_OTHERS`
--

CREATE TABLE IF NOT EXISTS `2020_OTHERS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `2020_OTHERS`
--

INSERT INTO `2020_OTHERS` (`ID`, `NAME`) VALUES
(1, '2020/2021'),
(2, '11'),
(3, '2021-01-04');

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_PDF_FILES`
--

CREATE TABLE IF NOT EXISTS `2020_PDF_FILES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPTION` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `CREATED` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CATEGORY` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CATEGORY_ID` (`CATEGORY`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_POSITIONS`
--

CREATE TABLE IF NOT EXISTS `2020_POSITIONS` (
  `POSITION` int(11) NOT NULL AUTO_INCREMENT,
  `POSITION_NAME` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`POSITION`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=8 ;

--
-- Vypisuji data pro tabulku `2020_POSITIONS`
--

INSERT INTO `2020_POSITIONS` (`POSITION`, `POSITION_NAME`) VALUES
(1, 'Ředitel'),
(2, 'Kuchař'),
(3, 'Učitel'),
(4, 'Vychovatel'),
(5, 'Školní rada'),
(6, 'Ostatní');

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_RINGING`
--

CREATE TABLE IF NOT EXISTS `2020_RINGING` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `HOUR` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `START` time NOT NULL,
  `END` time NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=119 ;

--
-- Vypisuji data pro tabulku `2020_RINGING`
--

INSERT INTO `2020_RINGING` (`ID`, `HOUR`, `START`, `END`) VALUES
(78, '1. hodina', '07:45:00', '08:30:00'),
(79, '2. hodina', '08:40:00', '09:25:00'),
(80, 'Velká přestávka', '09:25:00', '09:45:00'),
(81, '3. hodina', '09:45:00', '10:30:00'),
(82, '4. hodina', '10:40:00', '11:25:00'),
(83, '5. hodina', '11:35:00', '12:20:00'),
(84, 'Přestávka na oběd', '12:20:00', '13:00:00'),
(85, '7. hodina', '13:00:00', '13:45:00'),
(86, '8. hodina', '13:55:00', '14:45:00'),
(87, 'Provoz školní družiny', '14:20:00', '15:50:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_SCHEDULES`
--

CREATE TABLE IF NOT EXISTS `2020_SCHEDULES` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DAY` varchar(50) CHARACTER SET utf8 NOT NULL,
  `FIRST` varchar(50) CHARACTER SET utf8 NOT NULL,
  `SECOND` varchar(50) CHARACTER SET utf8 NOT NULL,
  `THIRD` varchar(50) CHARACTER SET utf8 NOT NULL,
  `FOURTH` varchar(50) CHARACTER SET utf8 NOT NULL,
  `FIFTH` varchar(50) CHARACTER SET utf8 NOT NULL,
  `SIXTH` varchar(50) CHARACTER SET utf8 NOT NULL,
  `SEVENTH` varchar(50) CHARACTER SET utf8 NOT NULL,
  `EIGHTH` varchar(50) CHARACTER SET utf8 NOT NULL,
  `CLASS` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `2020_USERS`
--

CREATE TABLE IF NOT EXISTS `2020_USERS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(100) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `PASSWORD` varchar(300) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `MAIL` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `NEW_PASS` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  `ADMIN` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  `UVOD` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  `SKOLNI_ROK` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  `FOTKY` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  `TRIDY` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  `DOKUMENTY` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  `JIDELNA` varchar(1) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  `ACTIVE` varchar(1) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`USERNAME`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci AUTO_INCREMENT=81 ;

--
-- Vypisuji data pro tabulku `2020_USERS`
--

INSERT INTO `2020_USERS` (`ID`, `USERNAME`, `PASSWORD`, `MAIL`, `NEW_PASS`, `ADMIN`, `UVOD`, `SKOLNI_ROK`, `FOTKY`, `TRIDY`, `DOKUMENTY`, `JIDELNA`, `ACTIVE`) VALUES
(80, 'test.user', '$2y$10$9M9XEph4N3W8g1.agBnNLeH/KBUkkEUL/jM3zi66IQbP8GtyB1Yw2', 'testUser@domain.com', '1', '1', '0', '0', '0', '0', '0', '0', '1');

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `2020_EMPLOYEES`
--
ALTER TABLE `2020_EMPLOYEES`
  ADD CONSTRAINT `2020_EMPLOYEES_ibfk_3` FOREIGN KEY (`POSITION`) REFERENCES `2020_POSITIONS` (`POSITION`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `2020_EVENTS`
--
ALTER TABLE `2020_EVENTS`
  ADD CONSTRAINT `2020_EVENTS_ibfk_4` FOREIGN KEY (`EVENT_ID`) REFERENCES `2020_EVENTS_TYPE` (`EVENT_ID`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `2020_FOTOGALERY`
--
ALTER TABLE `2020_FOTOGALERY`
  ADD CONSTRAINT `2020_FOTOGALERY_ibfk_1` FOREIGN KEY (`CATEGORY_ID`) REFERENCES `2020_FOTOGALERY_CATEGORY` (`CATEGORY_ID`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `2020_NOTIFICATION`
--
ALTER TABLE `2020_NOTIFICATION`
  ADD CONSTRAINT `2020_NOTIFICATION_ibfk_1` FOREIGN KEY (`CATEGORY`) REFERENCES `2020_CATEGORIES` (`CATEGORY`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `2020_PDF_FILES`
--
ALTER TABLE `2020_PDF_FILES`
  ADD CONSTRAINT `2020_PDF_FILES_ibfk_3` FOREIGN KEY (`CATEGORY`) REFERENCES `2020_CATEGORIES` (`CATEGORY`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
