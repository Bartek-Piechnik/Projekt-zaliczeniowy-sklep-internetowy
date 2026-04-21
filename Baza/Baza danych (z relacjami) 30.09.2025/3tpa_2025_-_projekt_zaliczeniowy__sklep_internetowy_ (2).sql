-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Wrz 30, 2025 at 11:28 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3tpa 2025 - projekt zaliczeniowy (sklep internetowy)`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `Kategoria_id` tinyint(3) UNSIGNED NOT NULL,
  `Nazwa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Opis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `Zdjecie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `Klient_id` tinyint(3) UNSIGNED NOT NULL,
  `Imie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Nazwisko` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `E-mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Telefon` varchar(20) NOT NULL,
  `Adres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Data_dodania` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyki`
--

CREATE TABLE `koszyki` (
  `Koszyk_id` tinyint(3) UNSIGNED NOT NULL,
  `id_sesji` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Data_utworzenia` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `metody_platnosci`
--

CREATE TABLE `metody_platnosci` (
  `Metoda_platnosci_id` tinyint(3) UNSIGNED NOT NULL,
  `Nazwa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Opis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `metody_wysylki`
--

CREATE TABLE `metody_wysylki` (
  `Metoda_wysylki_id` tinyint(3) UNSIGNED NOT NULL,
  `Nazwa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Koszt` decimal(10,2) NOT NULL,
  `Darmowa_od` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinie`
--

CREATE TABLE `opinie` (
  `Opinia_id` tinyint(3) UNSIGNED NOT NULL,
  `Produkt_id` tinyint(3) UNSIGNED NOT NULL,
  `Klient_id` tinyint(3) UNSIGNED NOT NULL,
  `Ocena` tinyint(3) UNSIGNED NOT NULL,
  `Komentarz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `Data_dodania` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pozycje_koszyka`
--

CREATE TABLE `pozycje_koszyka` (
  `Pozycja_koszyka_id` tinyint(3) UNSIGNED NOT NULL,
  `Koszyk_id` tinyint(3) UNSIGNED NOT NULL,
  `Produkt_id` tinyint(3) UNSIGNED NOT NULL,
  `Ilosc` smallint(5) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pozycje_zamowienia`
--

CREATE TABLE `pozycje_zamowienia` (
  `Pozycja_zamowienia_id` tinyint(3) UNSIGNED NOT NULL,
  `Zamowienia_id` tinyint(3) UNSIGNED NOT NULL,
  `Produkty_id` tinyint(3) UNSIGNED NOT NULL,
  `Ilosc` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `Cena_jednostkowa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `Produkt_id` tinyint(3) UNSIGNED NOT NULL,
  `Kategoria_id` tinyint(3) UNSIGNED NOT NULL,
  `Nazwa` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Opis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `Cena` decimal(10,2) NOT NULL,
  `Stan_magazynowy` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `Dostepnosc` tinyint(4) NOT NULL DEFAULT 1,
  `Data_dodania` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `Zamowienie_id` tinyint(3) UNSIGNED NOT NULL,
  `Klient_id` tinyint(3) UNSIGNED NOT NULL,
  `Metody_wysylki_id` tinyint(3) UNSIGNED NOT NULL,
  `Metody_platnosci_id` tinyint(3) UNSIGNED NOT NULL,
  `Kwota_laczna` decimal(10,2) NOT NULL,
  `Status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL DEFAULT '''Nowe''',
  `Data_zamowienia` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia_produktow`
--

CREATE TABLE `zdjecia_produktow` (
  `Zdjecie_produktu_id` tinyint(3) UNSIGNED NOT NULL,
  `Produkt_id` tinyint(3) UNSIGNED NOT NULL,
  `Sciezka_do_zdjecia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Czy_glowne` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`Kategoria_id`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`Klient_id`);

--
-- Indeksy dla tabeli `koszyki`
--
ALTER TABLE `koszyki`
  ADD PRIMARY KEY (`Koszyk_id`);

--
-- Indeksy dla tabeli `metody_platnosci`
--
ALTER TABLE `metody_platnosci`
  ADD PRIMARY KEY (`Metoda_platnosci_id`);

--
-- Indeksy dla tabeli `metody_wysylki`
--
ALTER TABLE `metody_wysylki`
  ADD PRIMARY KEY (`Metoda_wysylki_id`);

--
-- Indeksy dla tabeli `opinie`
--
ALTER TABLE `opinie`
  ADD PRIMARY KEY (`Opinia_id`),
  ADD KEY `Produkt_id` (`Produkt_id`,`Klient_id`),
  ADD KEY `Klient_id` (`Klient_id`);

--
-- Indeksy dla tabeli `pozycje_koszyka`
--
ALTER TABLE `pozycje_koszyka`
  ADD PRIMARY KEY (`Pozycja_koszyka_id`),
  ADD KEY `Koszyk_id` (`Koszyk_id`,`Produkt_id`);

--
-- Indeksy dla tabeli `pozycje_zamowienia`
--
ALTER TABLE `pozycje_zamowienia`
  ADD PRIMARY KEY (`Pozycja_zamowienia_id`),
  ADD KEY `Zamowienia_id` (`Zamowienia_id`,`Produkty_id`),
  ADD KEY `Produkty_id` (`Produkty_id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`Produkt_id`),
  ADD UNIQUE KEY `Kategoria_id` (`Kategoria_id`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`Zamowienie_id`),
  ADD KEY `Klient_id` (`Klient_id`,`Metody_wysylki_id`,`Metody_platnosci_id`),
  ADD KEY `Metody_wysylki_id` (`Metody_wysylki_id`),
  ADD KEY `Metody_platnosci_id` (`Metody_platnosci_id`);

--
-- Indeksy dla tabeli `zdjecia_produktow`
--
ALTER TABLE `zdjecia_produktow`
  ADD PRIMARY KEY (`Zdjecie_produktu_id`),
  ADD UNIQUE KEY `Produkt_id` (`Produkt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `Kategoria_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `Klient_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `koszyki`
--
ALTER TABLE `koszyki`
  MODIFY `Koszyk_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metody_platnosci`
--
ALTER TABLE `metody_platnosci`
  MODIFY `Metoda_platnosci_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metody_wysylki`
--
ALTER TABLE `metody_wysylki`
  MODIFY `Metoda_wysylki_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opinie`
--
ALTER TABLE `opinie`
  MODIFY `Opinia_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pozycje_koszyka`
--
ALTER TABLE `pozycje_koszyka`
  MODIFY `Pozycja_koszyka_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pozycje_zamowienia`
--
ALTER TABLE `pozycje_zamowienia`
  MODIFY `Pozycja_zamowienia_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `Produkt_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `Zamowienie_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zdjecia_produktow`
--
ALTER TABLE `zdjecia_produktow`
  MODIFY `Zdjecie_produktu_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD CONSTRAINT `kategorie_ibfk_1` FOREIGN KEY (`Kategoria_id`) REFERENCES `produkty` (`Kategoria_id`);

--
-- Constraints for table `klienci`
--
ALTER TABLE `klienci`
  ADD CONSTRAINT `klienci_ibfk_1` FOREIGN KEY (`Klient_id`) REFERENCES `zamowienia` (`Klient_id`);

--
-- Constraints for table `opinie`
--
ALTER TABLE `opinie`
  ADD CONSTRAINT `opinie_ibfk_1` FOREIGN KEY (`Opinia_id`) REFERENCES `produkty` (`Produkt_id`),
  ADD CONSTRAINT `opinie_ibfk_2` FOREIGN KEY (`Klient_id`) REFERENCES `klienci` (`Klient_id`);

--
-- Constraints for table `pozycje_koszyka`
--
ALTER TABLE `pozycje_koszyka`
  ADD CONSTRAINT `pozycje_koszyka_ibfk_1` FOREIGN KEY (`Koszyk_id`) REFERENCES `koszyki` (`Koszyk_id`);

--
-- Constraints for table `pozycje_zamowienia`
--
ALTER TABLE `pozycje_zamowienia`
  ADD CONSTRAINT `pozycje_zamowienia_ibfk_1` FOREIGN KEY (`Produkty_id`) REFERENCES `produkty` (`Produkt_id`);

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`Produkt_id`) REFERENCES `zdjecia_produktow` (`Produkt_id`);

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`Zamowienie_id`) REFERENCES `pozycje_zamowienia` (`Zamowienia_id`),
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`Metody_wysylki_id`) REFERENCES `metody_wysylki` (`Metoda_wysylki_id`),
  ADD CONSTRAINT `zamowienia_ibfk_3` FOREIGN KEY (`Metody_platnosci_id`) REFERENCES `metody_platnosci` (`Metoda_platnosci_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
