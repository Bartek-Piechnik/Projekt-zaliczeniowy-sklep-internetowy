-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 17, 2026 at 12:05 PM
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
-- Struktura tabeli dla tabeli `admin`
--

CREATE TABLE `admin` (
  `Admin_id` int(11) NOT NULL,
  `Login` varchar(100) NOT NULL,
  `Haslo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_id`, `Login`, `Haslo`) VALUES
(1, 'Admin', '$2y$10$YTXvXirpaqWOI/QUi5I4wuuLvg7nkBXyLOvLVVfW2IVFuSt8JcCtK');

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
  `Adres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL
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
  `Sciezka_do_zdjecia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_id`),
  ADD UNIQUE KEY `Login` (`Login`);

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
  ADD KEY `opinie_produkt_fk` (`Produkt_id`),
  ADD KEY `opinie_klient_fk` (`Klient_id`);

--
-- Indeksy dla tabeli `pozycje_koszyka`
--
ALTER TABLE `pozycje_koszyka`
  ADD PRIMARY KEY (`Pozycja_koszyka_id`),
  ADD KEY `pozycje_koszyk_fk` (`Koszyk_id`),
  ADD KEY `pozycje_koszyk_produkt_fk` (`Produkt_id`);

--
-- Indeksy dla tabeli `pozycje_zamowienia`
--
ALTER TABLE `pozycje_zamowienia`
  ADD PRIMARY KEY (`Pozycja_zamowienia_id`),
  ADD KEY `pozycje_zamowienia_zamowienie_fk` (`Zamowienia_id`),
  ADD KEY `pozycje_zamowienia_produkt_fk` (`Produkty_id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`Produkt_id`),
  ADD KEY `produkty_kategoria_fk` (`Kategoria_id`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`Zamowienie_id`),
  ADD KEY `zamowienia_klient_fk` (`Klient_id`),
  ADD KEY `zamowienia_wysylka_fk` (`Metody_wysylki_id`),
  ADD KEY `zamowienia_platnosc_fk` (`Metody_platnosci_id`);

--
-- Indeksy dla tabeli `zdjecia_produktow`
--
ALTER TABLE `zdjecia_produktow`
  ADD PRIMARY KEY (`Zdjecie_produktu_id`),
  ADD KEY `zdjecia_produkt_fk` (`Produkt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `opinie`
--
ALTER TABLE `opinie`
  ADD CONSTRAINT `opinie_klient_fk` FOREIGN KEY (`Klient_id`) REFERENCES `klienci` (`Klient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `opinie_produkt_fk` FOREIGN KEY (`Produkt_id`) REFERENCES `produkty` (`Produkt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pozycje_koszyka`
--
ALTER TABLE `pozycje_koszyka`
  ADD CONSTRAINT `pozycje_koszyk_fk` FOREIGN KEY (`Koszyk_id`) REFERENCES `koszyki` (`Koszyk_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pozycje_koszyk_produkt_fk` FOREIGN KEY (`Produkt_id`) REFERENCES `produkty` (`Produkt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pozycje_zamowienia`
--
ALTER TABLE `pozycje_zamowienia`
  ADD CONSTRAINT `pozycje_zamowienia_produkt_fk` FOREIGN KEY (`Produkty_id`) REFERENCES `produkty` (`Produkt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pozycje_zamowienia_zamowienie_fk` FOREIGN KEY (`Zamowienia_id`) REFERENCES `zamowienia` (`Zamowienie_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_kategoria_fk` FOREIGN KEY (`Kategoria_id`) REFERENCES `kategorie` (`Kategoria_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_klient_fk` FOREIGN KEY (`Klient_id`) REFERENCES `klienci` (`Klient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamowienia_platnosc_fk` FOREIGN KEY (`Metody_platnosci_id`) REFERENCES `metody_platnosci` (`Metoda_platnosci_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamowienia_wysylka_fk` FOREIGN KEY (`Metody_wysylki_id`) REFERENCES `metody_wysylki` (`Metoda_wysylki_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zdjecia_produktow`
--
ALTER TABLE `zdjecia_produktow`
  ADD CONSTRAINT `zdjecia_produkt_fk` FOREIGN KEY (`Produkt_id`) REFERENCES `produkty` (`Produkt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
