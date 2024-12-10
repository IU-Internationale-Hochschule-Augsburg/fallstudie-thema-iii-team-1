-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: sql11.freesqldatabase.com
-- Erstellungszeit: 22. Jul 2024 um 10:51
-- Server-Version: 5.5.62-0ubuntu0.14.04.1
-- PHP-Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `sql11700785`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buchungen`
--

CREATE TABLE `buchungen` (
  `id_Buchung` int(11) NOT NULL,
  `gastName` varchar(45) NOT NULL,
  `datum` datetime NOT NULL,
  `anzahlPersonen` int(11) NOT NULL,
  `id_Tisch` int(11) NOT NULL,
  `id_Mitarbeiter` int(11) NOT NULL,
  `kommentar` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `buchungen`
--

INSERT INTO `buchungen` (`id_Buchung`, `gastName`, `datum`, `anzahlPersonen`, `id_Tisch`, `id_Mitarbeiter`, `kommentar`) VALUES
(3, 'mueller', '2024-05-01 20:00:00', 3, 3, 3, 'Rollstuhl'),
(85, 'test', '2024-06-07 10:45:00', 4, 4, 2, '4'),
(86, 'test', '2024-06-24 10:15:00', 4, 4, 4, '4'),
(87, 'ga', '2024-06-22 10:00:00', 1, 1, 2, '345'),
(88, 'test2', '2024-06-22 10:00:00', 4, 4, 2, '4'),
(89, 'Rudolf RÃ¼diger', '2024-10-02 12:15:00', 3, 2, 5, 'Brauchen einen Kinderstuhl'),
(90, 'Tom Hugo', '2024-10-02 12:00:00', 5, 4, 6, '0176 98765432'),
(92, 'grd', '2024-06-27 10:45:00', 4, 4, 1, '4'),
(93, 'afds', '2024-06-27 13:45:00', 6, 6, 2, '6'),
(94, 'afds', '2024-06-27 21:00:00', 5, 1, 2, '5'),
(95, 'gdf', '2024-06-22 13:00:00', 4, 1, 2, 'dgf'),
(96, 'test', '2024-06-22 14:00:00', 6, 1, 2, 'dfg'),
(97, 'afds', '2024-06-22 20:00:00', 6, 1, 2, '4'),
(98, 'dfg', '2024-06-20 10:30:00', 4, 1, 1, 'dfg'),
(99, 'test2', '2024-06-21 10:15:00', 4, 1, 1, '4'),
(100, 'gafg', '2024-06-30 11:15:00', 4, 4, 4, '4'),
(101, 'agf', '2024-06-22 10:30:00', 5, 3, 4, 'fg'),
(102, 'dgf', '2024-06-07 17:15:00', 4, 4, 2, '4'),
(103, 'Florian Sefzik', '2024-06-29 10:00:00', 4, 4, 3, '4'),
(104, 'dsfgh', '2024-07-04 10:30:00', 4, 8, 1, '5'),
(106, 'shdf', '2024-07-10 10:15:00', 4, 5, 1, '4'),
(107, 'hfgsd', '2024-07-10 11:15:00', 4, 4, 2, '45'),
(108, 'shs', '2024-07-10 12:15:00', 3, 4, 2, '56'),
(109, 'shddhs', '2024-07-10 12:00:00', 5, 5, 2, '55'),
(110, 'sfdg', '2024-07-03 11:00:00', 4, 4, 1, '4'),
(111, 'Maria Cener', '2024-08-30 19:00:00', 5, 5, 5, ''),
(112, 'Pascal WÃ¼nsche', '2024-07-20 21:00:00', 5, 6, 2, 'pascal.wuensche@mailbox.net'),
(113, 'Susanna Ralle', '2024-07-18 10:15:00', 4, 2, 4, ''),
(114, 'Angi Huber', '2024-07-19 11:00:00', 4, 3, 2, 'Mit Hund'),
(115, 'Florian', '2024-07-11 10:45:00', 5, 6, 2, '6'),
(116, 'adfh', '2024-07-11 10:30:00', 5, 5, 4, 'dg4'),
(117, '&lt;&gt;?test', '2024-07-11 11:00:00', 5, 7, 2, '<?dfg'),
(118, 'Martin Maier', '2024-07-12 17:15:00', 5, 3, 4, '0157 99887766'),
(119, 'Betty Hauser', '2024-07-12 12:00:00', 5, 3, 2, ''),
(120, 'Tanja Haertl', '2024-07-24 10:00:00', 4, 2, 1, 'Mit zwei Hunden'),
(121, 'Elias Wagner', '2024-07-17 10:30:00', 5, 7, 1, ''),
(122, '; DROP TABLE test1;', '2024-07-11 10:00:00', 4, 1, 2, 'aggasf'),
(123, 'Test6', '2024-07-11 10:15:00', 4, 3, 1, 'DROP TABLE test1'),
(124, 'Lena Sommer', '2024-07-12 17:45:00', 5, 4, 2, 'Geburtstagsfeier lena.sommer@example.com'),
(125, 'Max Bauer', '2024-07-12 17:45:00', 5, 7, 5, ''),
(128, 'Tim Becker', '2024-07-20 15:15:00', 6, 3, 1, 'tim.becker@tempmail.com'),
(130, 'afds', '2024-07-10 10:45:00', 5, 2, 1, 'dfg'),
(131, 'Test11111111111111111111111111111111111111111', '2024-01-10 10:30:00', 9, 5, 6, '111111111111111111111111111111111111111111111'),
(133, 'Test4', '2024-07-11 10:45:00', 6, 8, 1, 'Test'),
(134, 'Test3', '2024-07-11 10:30:00', 8, 4, 6, 'TettrwrhsrhdrhTettrwrhsrhdrhTettrwrhsrhdrhTet'),
(135, 'Laura Fenk', '2024-07-19 19:00:00', 5, 5, 5, ''),
(136, 'Erik Braun', '2024-07-12 13:00:00', 4, 6, 6, '0160 11223344'),
(138, 'Marcia Grantaire', '2024-07-19 14:15:00', 9, 5, 2, 'Rotwein'),
(139, 'Test1', '2024-07-10 10:00:00', 3, 3, 6, 'Test1'),
(140, 'Sophie Huber', '2024-07-20 12:00:00', 5, 5, 5, ''),
(142, 'Thomas Raab', '2024-07-20 13:00:00', 6, 4, 5, ''),
(143, 'Lena Mayr', '2024-07-26 18:30:00', 5, 5, 6, 'Mit Rollstuhl'),
(144, 'Pascal WÃ¼nsche', '2024-07-20 15:00:00', 5, 2, 5, ''),
(145, 'Roland Fischer', '2024-08-10 20:00:00', 5, 4, 6, 'Roland.Fischer1@fakemail.org'),
(146, 'Pascal', '2024-07-14 18:00:00', 5, 5, 5, 'Mit Rohlstuhl'),
(147, 'einer', '2024-07-18 13:45:00', 9, 5, 4, '-');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logins`
--

CREATE TABLE `logins` (
  `id_Login` int(11) NOT NULL,
  `password` varchar(60) NOT NULL,
  `LoginName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `logins`
--

INSERT INTO `logins` (`id_Login`, `password`, `LoginName`) VALUES
(18, '$2y$10$82UbJYxo5HRrbdUYM3t60.aheY3n30ekegg8bZbybrzEpyOVAyDce', 'Florian'),
(19, '$2y$10$nuT2Xd/biDZzyBf.866BDerHCflk5Ipjr4iuRq5SYmsOgnLwHe40y', 'Aurelius'),
(20, '$2y$10$0pjy3IY6IdnBtp.76.zBruwRmMaaNfya6d9sh7XVAqmu9wg3BerUK', 'Tanja'),
(21, '$2y$10$JA0q5oW/XqyYB4KY9mN5K.hKW5O8MyuSgbZBrpNHwhmmJid0fJ2Vq', 'Tim'),
(22, '$2y$10$dgQKqCRu0s8/3Hd3t5EB0Or7w3diI1B2kQQTfrfGeRa1c6cZlHthO', 'Pascal'),
(24, '$2y$10$J65xTAQf/cDklbwrDexVp.Rl4drzL1zi1OzjE6ZQI8yHH.LhYTv6e', 'admin'),
(25, '$2y$10$d6ubfbZbUhOXJzLMGnaU3ueKuHqE4pkDcV/v8nEyEuYZ7MKz6peAu', 'testuser123'),
(26, '$2y$10$L3NfMgzE4VXYDt.xmXowRO7HiHb3SHVGxc9beU7tHWqfnSRnZ8ZBu', 'Test1'),
(27, '$2y$10$Uw6Zkdal0YJnc367t9Qc3eClqolHdUqggx5kvqyGPXi2eIShT8kQC', 'Timm'),
(28, '$2y$10$kVzY.qMl6eWXT9YHiNzxPeW78NokJlUpbZh82X10ncdvCeFNxWs8i', 'Test1'),
(29, '$2y$10$LROlh415jjfSlkL83REiPe0pep3BLyj3eUKd9QmTNe9JsI6.DRlNG', 'Test1'),
(30, '$2y$10$SHBpdzXM1UJWpmyLERlQuePc0RJYJHhKcJDPilFJuiWJG/sSmmVyq', 'Test3');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitarbeiter`
--

CREATE TABLE `mitarbeiter` (
  `id_Mitarbeiter` int(11) NOT NULL,
  `nachname` varchar(45) NOT NULL,
  `vorname` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `mitarbeiter`
--

INSERT INTO `mitarbeiter` (`id_Mitarbeiter`, `nachname`, `vorname`) VALUES
(1, 'Sefzik', 'Florian'),
(2, 'Zehnder', 'Aurelius'),
(3, 'Priller', 'Martin'),
(4, 'Haertl', 'Tanja'),
(5, 'Wuensche', 'Pascal'),
(6, 'Schmitt', 'Tim');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `oeffnungszeiten`
--

CREATE TABLE `oeffnungszeiten` (
  `id_wochentag` int(11) NOT NULL,
  `wochentag` varchar(45) DEFAULT NULL,
  `vormStart` time DEFAULT NULL,
  `vormEnde` time DEFAULT NULL,
  `nachmStart` time DEFAULT NULL,
  `nachmEnde` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `oeffnungszeiten`
--

INSERT INTO `oeffnungszeiten` (`id_wochentag`, `wochentag`, `vormStart`, `vormEnde`, `nachmStart`, `nachmEnde`) VALUES
(0, 'Montag', '11:00:00', '14:00:00', '15:00:00', '22:00:00'),
(1, 'Dienstag', '00:00:00', '00:00:00', '00:00:00', '00:00:00'),
(2, 'Mittwoch', '10:00:00', '12:00:00', '13:00:00', '15:00:00'),
(3, 'Donnerstag', '10:00:00', '12:00:00', '13:00:00', '15:00:00'),
(4, 'Freitag', '17:00:00', '23:00:00', '00:00:00', '00:00:00'),
(5, 'Samstag', '10:00:00', '14:00:00', '13:00:00', '16:00:00'),
(6, 'Sonntag', '11:00:00', '13:00:00', '14:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `test1`
--

CREATE TABLE `test1` (
  `idtest1` int(11) NOT NULL,
  `test1col` varchar(45) DEFAULT NULL,
  `test1col1` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `test1`
--

INSERT INTO `test1` (`idtest1`, `test1col`, `test1col1`) VALUES
(1, 'gdsf', NULL),
(3, '45', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tische`
--

CREATE TABLE `tische` (
  `id_Tisch` int(11) NOT NULL,
  `anzahlPlaetze` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tische`
--

INSERT INTO `tische` (`id_Tisch`, `anzahlPlaetze`) VALUES
(1, 4),
(2, 6),
(3, 7),
(4, 8),
(5, 9),
(6, 5),
(7, 5),
(8, 6);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `buchungen`
--
ALTER TABLE `buchungen`
  ADD PRIMARY KEY (`id_Buchung`),
  ADD KEY `FK1` (`id_Tisch`),
  ADD KEY `FK2` (`id_Mitarbeiter`);

--
-- Indizes für die Tabelle `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id_Login`);

--
-- Indizes für die Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  ADD PRIMARY KEY (`id_Mitarbeiter`);

--
-- Indizes für die Tabelle `oeffnungszeiten`
--
ALTER TABLE `oeffnungszeiten`
  ADD PRIMARY KEY (`id_wochentag`);

--
-- Indizes für die Tabelle `test1`
--
ALTER TABLE `test1`
  ADD PRIMARY KEY (`idtest1`);

--
-- Indizes für die Tabelle `tische`
--
ALTER TABLE `tische`
  ADD PRIMARY KEY (`id_Tisch`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `buchungen`
--
ALTER TABLE `buchungen`
  MODIFY `id_Buchung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT für Tabelle `logins`
--
ALTER TABLE `logins`
  MODIFY `id_Login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT für Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  MODIFY `id_Mitarbeiter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `tische`
--
ALTER TABLE `tische`
  MODIFY `id_Tisch` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `buchungen`
--
ALTER TABLE `buchungen`
  ADD CONSTRAINT `FK1` FOREIGN KEY (`id_Tisch`) REFERENCES `tische` (`id_Tisch`),
  ADD CONSTRAINT `FK2` FOREIGN KEY (`id_Mitarbeiter`) REFERENCES `mitarbeiter` (`id_Mitarbeiter`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
