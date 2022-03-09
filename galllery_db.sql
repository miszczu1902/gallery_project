-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Sty 2020, 11:09
-- Wersja serwera: 10.4.6-MariaDB
-- Wersja PHP: 7.3.9

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
AUTOCOMMIT = 0;
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `miszczak_4ta`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `albumy`
--

CREATE TABLE `albumy`
(
    `id`             int(11) NOT NULL,
    `tytul`          varchar(100) COLLATE utf8_polish_ci NOT NULL,
    `data`           datetime                            NOT NULL,
    `id_uzytkownika` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `albumy`
--

INSERT INTO `albumy` (`id`, `tytul`, `data`, `id_uzytkownika`)
VALUES (85, 'Krajobrazy', '2019-11-29 10:47:05', 43),
       (86, 'Real Madryt', '2019-11-29 10:52:00', 43),
       (87, 'Samochody', '2019-11-29 10:52:38', 43),
       (89, 'Brazylia', '2019-11-29 10:53:51', 45),
       (90, 'Afryka', '2019-11-29 10:54:22', 45),
       (91, 'Australia', '2019-11-29 10:54:51', 45),
       (92, 'Polska', '2019-11-29 10:55:31', 45),
       (93, 'Tapety', '2019-11-29 11:23:48', 45),
       (96, 'Lego', '2019-11-29 11:38:58', 44),
       (97, 'Wakacje', '2019-11-29 11:39:14', 44),
       (98, 'Brazylia', '2019-11-29 11:39:46', 44),
       (99, 'Psy', '2019-11-29 11:41:10', 44),
       (100, 'Koty', '2019-11-29 11:41:57', 44),
       (101, 'Węże', '2019-11-29 11:43:59', 44),
       (102, 'Na pulpit', '2019-11-29 11:44:53', 44),
       (103, 'Wakacje', '2019-11-29 11:46:25', 44),
       (104, 'Wakacje', '2019-11-29 12:09:33', 43),
       (105, 'Tapety', '2019-11-29 12:16:24', 43);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy`
(
    `id`             int(11) NOT NULL,
    `login`          varchar(20) COLLATE utf8_polish_ci  NOT NULL,
    `haslo`          varchar(32) COLLATE utf8_polish_ci  NOT NULL,
    `email`          varchar(128) COLLATE utf8_polish_ci NOT NULL,
    `zarejestrowany` date                                NOT NULL,
    `uprawnienia`    enum('użytkownik','moderator','administrator','') COLLATE utf8_polish_ci NOT NULL,
    `aktywny`        tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`, `zarejestrowany`,
                           `uprawnienia`, `aktywny`)
VALUES (43, 'administrator1', 'd41d8cd98f00b204e9800998ecf8427e',
        'admin@admin.pl', '2019-10-23', 'administrator', 1),
       (44, 'moderator', 'e267cfcd18461ce938067eca67c59f41',
        'moderator@mod.com', '2019-10-23', 'moderator', 1),
       (45, 'User01', 'd41d8cd98f00b204e9800998ecf8427e', 'User01@wp.pl',
        '2019-10-23', 'użytkownik', 1),
       (61, 'administrator2', 'e267cfcd18461ce938067eca67c59f41',
        'admin2@wp.pl', '2020-01-09', 'administrator', 1),
       (62, 'User00', '926a779a131a4702263c0f11180146d0', 'wsdwdwdw@wp.com',
        '2020-01-22', 'użytkownik', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia`
--

CREATE TABLE `zdjecia`
(
    `id`            int(11) NOT NULL,
    `opis`          varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `id_albumu`     int(11) NOT NULL,
    `data`          datetime                            NOT NULL,
    `zaakceptowane` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia`
--

INSERT INTO `zdjecia` (`id`, `opis`, `id_albumu`, `data`, `zaakceptowane`)
VALUES (441, '', 85, '2019-11-29 10:47:30', 1),
       (442, '', 85, '2019-11-29 10:47:42', 1),
       (444, 'Opis', 85, '2019-11-29 10:51:42', 1),
       (445, '', 85, '2019-11-29 10:51:48', 1),
       (446, '', 86, '2019-11-29 10:52:20', 1),
       (447, 'Hala Madrid <3', 86, '2019-11-29 10:52:26', 1),
       (448, '', 86, '2019-11-29 10:52:30', 1),
       (449, 'Passat', 87, '2019-11-29 10:52:51', 1),
       (450, 'Vectra B', 87, '2019-11-29 10:52:59', 1),
       (452, '', 89, '2019-11-29 10:53:58', 1),
       (453, '', 89, '2019-11-29 10:54:01', 1),
       (454, '', 90, '2019-11-29 10:54:30', 1),
       (455, '', 90, '2019-11-29 10:54:37', 1),
       (456, 'opk;;', 91, '2019-11-29 10:55:02', 1),
       (457, 'sdfdfdgfdg', 91, '2019-11-29 10:55:23', 1),
       (458, 'cccbfbfb', 92, '2019-11-29 10:55:47', 1),
       (459, '', 92, '2019-11-29 10:56:01', 1),
       (463, '', 89, '2019-11-29 11:09:42', 1),
       (464, '', 89, '2019-11-29 11:16:51', 1),
       (465, '', 89, '2019-11-29 11:17:40', 1),
       (467, '', 89, '2019-11-29 11:23:11', 1),
       (468, '', 93, '2019-11-29 11:23:57', 1),
       (469, '', 93, '2019-11-29 11:26:00', 1),
       (470, '', 93, '2019-11-29 11:28:32', 1),
       (471, '', 93, '2019-11-29 11:28:48', 1),
       (472, '', 94, '2019-11-29 11:36:52', 1),
       (473, '', 94, '2019-11-29 11:37:04', 1),
       (474, '', 94, '2019-11-29 11:37:15', 1),
       (477, 'Bugatti z Lego', 96, '2019-11-29 11:39:04', 1),
       (478, '', 97, '2019-11-29 11:39:25', 1),
       (479, '', 97, '2019-11-29 11:39:32', 1),
       (480, '', 98, '2019-11-29 11:39:57', 1),
       (481, '', 99, '2019-11-29 11:41:34', 1),
       (482, '', 99, '2019-11-29 11:41:39', 1),
       (483, '', 99, '2019-11-29 11:41:49', 1),
       (484, '', 101, '2019-11-29 11:44:10', 1),
       (485, '', 101, '2019-11-29 11:44:24', 1),
       (486, '', 102, '2019-11-29 11:44:59', 1),
       (487, '', 102, '2019-11-29 11:45:02', 1),
       (488, '', 102, '2019-11-29 11:45:42', 1),
       (489, '', 102, '2019-11-29 11:45:53', 1),
       (490, '', 103, '2019-11-29 11:46:31', 1),
       (491, '', 103, '2019-11-29 11:46:43', 1),
       (492, '', 100, '2019-11-29 11:46:58', 1),
       (493, '', 104, '2019-11-29 12:09:44', 1),
       (494, '', 104, '2019-11-29 12:10:05', 1),
       (495, '', 105, '2019-11-29 12:16:28', 1),
       (498, '', 105, '2019-11-29 12:17:13', 1),
       (510, '', 86, '2019-12-24 12:19:22', 1),
       (511, 'Valverde to kozak i wgl', 86, '2019-12-24 12:19:33', 1),
       (514, 'Porsche <33333', 87, '2019-12-24 15:36:21', 1),
       (515, '', 98, '2019-12-24 15:37:30', 1),
       (516, '', 96, '2019-12-26 12:41:24', 1),
       (517, '', 85, '2020-01-08 16:23:45', 1),
       (518, 'A to Sahara', 85, '2020-01-08 16:23:57', 1),
       (519, '', 85, '2020-01-08 16:24:00', 1),
       (527, '', 85, '2020-01-09 07:57:38', 1),
       (528, '', 86, '2020-01-18 19:18:10', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia_komentarze`
--

CREATE TABLE `zdjecia_komentarze`
(
    `id`             int(11) NOT NULL,
    `id_zdjecia`     int(11) NOT NULL,
    `id_uzytkownika` int(11) NOT NULL,
    `data`           datetime                    NOT NULL,
    `komentarz`      text COLLATE utf8_polish_ci NOT NULL,
    `zaakceptowany`  tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia_komentarze`
--

INSERT INTO `zdjecia_komentarze` (`id`, `id_zdjecia`, `id_uzytkownika`, `data`,
                                  `komentarz`, `zaakceptowany`)
VALUES (49, 448, 43, '2019-12-06 17:10:09', 'Bo Eden Hazard to kot', 1),
       (50, 447, 43, '2019-12-06 17:10:25', 'Hala Madrid', 1),
       (56, 511, 43, '2019-12-24 15:40:16', 'Ale zajefajne', 1),
       (57, 511, 43, '2019-12-24 15:40:21', 'Polecam', 1),
       (59, 446, 43, '2019-12-24 15:40:29', 'Ale ma strzał ', 1),
       (60, 447, 43, '2019-12-24 15:40:37', 'Vamos Real!', 1),
       (61, 477, 43, '2019-12-26 16:29:27', 'Takie naprawdę ', 1),
       (63, 519, 43, '2020-01-08 16:30:09', 'Czy to tu mieszkają murzyny?', 1),
       (73, 455, 43, '2020-01-09 08:43:47', 'Zebry <3', 1),
       (74, 516, 43, '2020-01-09 08:57:03', 'Klocuszkowa tapeta', 1),
       (75, 489, 43, '2020-01-09 08:57:14', 'Tapeta 1', 1),
       (76, 486, 43, '2020-01-09 08:57:19', 'Tapeta 2', 1),
       (77, 519, 44, '2020-01-09 09:43:04', 'Hahahaahaahahahaha', 1),
       (78, 454, 45, '2020-01-13 20:03:59', 'Afryczka', 1),
       (80, 453, 45, '2020-01-19 15:36:27', 'Małe coś', 1),
       (81, 464, 62, '2020-01-22 16:53:05', 'dgmjndeifnikfnepovmnjswfv', 1),
       (82, 452, 62, '2020-01-22 16:53:17', 'dsdegfasgfwefwsa', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia_oceny`
--

CREATE TABLE `zdjecia_oceny`
(
    `id_zdjecia`     int(11) NOT NULL,
    `id_uzytkownika` int(11) NOT NULL,
    `ocena`          tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia_oceny`
--

INSERT INTO `zdjecia_oceny` (`id_zdjecia`, `id_uzytkownika`, `ocena`)
VALUES (492, 43, 10),
       (515, 44, 1),
       (510, 43, 10),
       (511, 43, 10),
       (446, 43, 10),
       (447, 43, 10),
       (448, 43, 10),
       (455, 43, 7),
       (454, 43, 8),
       (483, 43, 6),
       (481, 43, 9),
       (482, 43, 8),
       (516, 43, 7),
       (519, 43, 8),
       (477, 43, 9),
       (514, 43, 10),
       (455, 45, 9),
       (454, 45, 7),
       (464, 45, 8),
       (465, 45, 9),
       (467, 45, 5),
       (452, 45, 9),
       (453, 45, 3),
       (457, 62, 9),
       (464, 62, 7),
       (465, 62, 6),
       (467, 62, 3),
       (452, 62, 10);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `albumy`
--
ALTER TABLE `albumy`
    ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
    ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
    ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zdjecia_komentarze`
--
ALTER TABLE `zdjecia_komentarze`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `albumy`
--
ALTER TABLE `albumy`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=529;

--
-- AUTO_INCREMENT dla tabeli `zdjecia_komentarze`
--
ALTER TABLE `zdjecia_komentarze`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
