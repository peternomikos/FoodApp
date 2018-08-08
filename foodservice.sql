-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 31 Ιουλ 2018 στις 15:49:07
-- Έκδοση διακομιστή: 5.7.14
-- Έκδοση PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `foodservice`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `costumer`
--

CREATE TABLE `costumer` (
  `email` varchar(50) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Telephone` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `manager`
--

CREATE TABLE `manager` (
  `Username` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Surname` varchar(25) NOT NULL,
  `AFM` varchar(10) NOT NULL,
  `AMKA` varchar(11) NOT NULL,
  `IBAN` varchar(27) NOT NULL,
  `Distributer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `manager`
--

INSERT INTO `manager` (`Username`, `Password`, `Name`, `Surname`, `AFM`, `AMKA`, `IBAN`, `Distributer`) VALUES
('Archer', 'Sterling', 'Gregory', 'Nikolopoulos', '1234567890', '09876543210', '12345BVYZ', 0),
('Cheryl', 'Tunt', 'Judy', 'Greer', '6284084756', '32584582410', 'BIQ6544123', 0),
('Cyril', 'Figgis', 'Chris', 'Parnell', '5678384756', '68584957340', 'HAT159123', 0),
('Lana', 'Kane', 'Aisha', 'Tyler', '1029384756', '67584930210', 'BAK789123', 0),
('Malory', 'Archer', 'Jessica', 'Walter', '4532943789', '09285493210', '1265KLVYZ', 0),
('Pam', 'Poovey', 'Amber', 'Poovey', '4863584756', '56124473850', 'FER8459123', 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `stock`
--

CREATE TABLE `stock` (
  `Shop_Name` varchar(30) NOT NULL,
  `Shop_Manager` varchar(20) NOT NULL,
  `Greek_Coffer_Price` float NOT NULL,
  `Frape_Price` float NOT NULL,
  `Espresso_Price` float NOT NULL,
  `Cappuccino_Price` float NOT NULL,
  `French_Coffer_Price` float NOT NULL,
  `Cheesepie_Price` float NOT NULL,
  `Simit_Price` float NOT NULL,
  `Tost_Price` float NOT NULL,
  `Cake_Price` float NOT NULL,
  `Spinachpie_Price` float NOT NULL,
  `Cheesepie_Reserve` float NOT NULL,
  `Simit_Reserve` float NOT NULL,
  `Tost_Reserve` float NOT NULL,
  `Cake_Reserve` float NOT NULL,
  `Spinachpie_Reserve` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `stock`
--

INSERT INTO `stock` (`Shop_Name`, `Shop_Manager`, `Greek_Coffer_Price`, `Frape_Price`, `Espresso_Price`, `Cappuccino_Price`, `French_Coffer_Price`, `Cheesepie_Price`, `Simit_Price`, `Tost_Price`, `Cake_Price`, `Spinachpie_Price`, `Cheesepie_Reserve`, `Simit_Reserve`, `Tost_Reserve`, `Cake_Reserve`, `Spinachpie_Reserve`) VALUES
('Makina', 'Archer', 1, 1.2, 1.4, 1.5, 1.3, 1, 0.5, 1, 1.2, 1.5, 10, 11, 30, 15, 24),
('Distinto', 'Cheryl', 1.1, 1.3, 1.5, 1.5, 1.3, 1, 0.5, 1, 1.2, 1.5, 10, 11, 30, 15, 24),
('Big Ben', 'Cyril', 1, 1.2, 1.5, 1.5, 1.3, 1, 0.5, 1, 1.2, 1.5, 10, 11, 30, 15, 24),
('Character', 'Lana', 1.1, 1.4, 1.4, 1.5, 1.3, 1, 0.5, 1, 1.2, 1.5, 10, 11, 30, 15, 24),
('Daboos City Lounge', 'Malory', 1.1, 1.3, 1.4, 1.5, 1.3, 1, 0.5, 1, 1.2, 1.5, 10, 11, 30, 15, 24),
('geLatino', 'Pam', 1, 1.2, 1.4, 1.5, 1.3, 1, 0.5, 1, 1.2, 1.5, 10, 11, 30, 15, 24);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `store`
--

CREATE TABLE `store` (
  `Store_Name` varchar(30) NOT NULL DEFAULT 'UNKNOWN',
  `Store_Street` varchar(30) NOT NULL DEFAULT 'UNKNOWN',
  `Store_Number` varchar(4) NOT NULL,
  `Store_City` varchar(30) NOT NULL DEFAULT 'UNKNOWN',
  `Store_TK` varchar(5) NOT NULL,
  `Store_Phone` varchar(10) NOT NULL,
  `Store_Lat` float(10,6) NOT NULL,
  `Store_Long` float(10,6) NOT NULL,
  `Store_Manager` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Άδειασμα δεδομένων του πίνακα `store`
--

INSERT INTO `store` (`Store_Name`, `Store_Street`, `Store_Number`, `Store_City`, `Store_TK`, `Store_Phone`, `Store_Lat`, `Store_Long`, `Store_Manager`) VALUES
('Big Ben', 'Agiou Nikolaou', '16', 'Patra', '26221', '2691031882', 38.248432, 21.736160, 'Cyril'),
('Character', 'Riga_Feraiou', '108', 'Patra', '26221', '2691058241', 38.246716, 21.733570, 'Lana'),
('Daboos City Lounge', 'Amerikis', '1', 'Patra', '26442', '2691023901', 38.242790, 21.730757, 'Malory'),
('Distinto', 'Posidonos', '25', 'Rio', '26504', '2690045672', 38.310745, 21.781530, 'Cheryl'),
('geLatino', 'Trion Navarchon', '29', 'Patra', '26222', '2691045920', 38.242790, 21.730782, 'Pam'),
('Makina', 'Patreos', '83', 'Patra', '26225', '2691015427', 38.244366, 21.735828, 'Archer');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `costumer`
--
ALTER TABLE `costumer`
  ADD PRIMARY KEY (`email`);

--
-- Ευρετήρια για πίνακα `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`Username`),
  ADD UNIQUE KEY `AFM` (`AFM`);

--
-- Ευρετήρια για πίνακα `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`Shop_Manager`,`Shop_Name`),
  ADD KEY `SHOPLINKSTORE` (`Shop_Name`);

--
-- Ευρετήρια για πίνακα `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`Store_Name`,`Store_Manager`),
  ADD KEY `THEMANAGER` (`Store_Manager`);

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `MANAGERLINKSTOCK` FOREIGN KEY (`Shop_Manager`) REFERENCES `manager` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SHOPLINKSTORE` FOREIGN KEY (`Shop_Name`) REFERENCES `store` (`Store_Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `THEMANAGER` FOREIGN KEY (`Store_Manager`) REFERENCES `manager` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
