-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 21, 2026 at 09:35 PM
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

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`Kategoria_id`, `Nazwa`, `Opis`, `Zdjecie`) VALUES
(1, 'Odzież', 'Kategoria Odzież obejmuje koszulki, bluzy, spodnie i dodatki. Znajdziesz tutaj modną i wygodną odzież na każdą okazję.', 'Grafiki/Kategorie/Kategoria Odzież.png'),
(2, 'Akcesoria', 'Kategoria Akcesoria obejmuje torby, plecaki, paski, biżuterię i drobne dodatki. Znajdziesz tutaj praktyczne i stylowe akcesoria na każdą okazję.', 'Grafiki/Kategorie/Kategoria Akcesoria.png'),
(3, 'Gadżety', 'Kategoria Gadżety obejmuje figurki, breloki, kubki i inne unikalne drobiazgi. Znajdziesz tutaj ciekawe produkty, które dodadzą charakteru Twojemu wnętrzu lub prezentowi.', 'Grafiki/Kategorie/Kategoria Gadżety.png');

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
  `Haslo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klienci`
--

INSERT INTO `klienci` (`Klient_id`, `Imie`, `Nazwisko`, `E-mail`, `Telefon`, `Adres`, `Haslo`) VALUES
(1, 'Bartek', 'Piechnik', 'bartek.piechnik@onet.pl', '123456789', 'Nowe Rybie 136', '$2y$10$R7hKBY.tIxa1WAFTonV.N.tjn0usOmLojr7DBDxQ6isGpu8x10D/6');

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
  `Opis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `Zdjecie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metody_platnosci`
--

INSERT INTO `metody_platnosci` (`Metoda_platnosci_id`, `Nazwa`, `Opis`, `Zdjecie`) VALUES
(1, 'Blik', 'Szybka i bezpieczna płatność mobilna – wpisz kod BLIK i potwierdź transakcję w aplikacji bankowej.', 'Grafiki/Metody płatności/Blik.png'),
(2, 'PayPal', 'Szybka i bezpieczna płatność online – zapłać kartą lub środkami PayPal bez podawania danych sklepowi.', 'Grafiki/Metody płatności/PayPal.png'),
(3, 'Płatność za pobraniem', 'Zapłać za zamówienie przy odbiorze przesyłki – gotówką lub kartą u kuriera.', 'Grafiki/Metody płatności/Płatność za pobraniem.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `metody_wysylki`
--

CREATE TABLE `metody_wysylki` (
  `Metoda_wysylki_id` tinyint(3) UNSIGNED NOT NULL,
  `Nazwa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `Opis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `Zdjecie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `Koszt` decimal(10,2) NOT NULL,
  `Darmowa_od` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metody_wysylki`
--

INSERT INTO `metody_wysylki` (`Metoda_wysylki_id`, `Nazwa`, `Opis`, `Zdjecie`, `Koszt`, `Darmowa_od`) VALUES
(1, 'DPD kurier', 'Szybka i bezpieczna dostawa kurierem DPD prosto pod wskazany adres.', 'Grafiki/Metody wysyłki/DPD kurier.png', 19.00, 100.00),
(2, 'InPost kurier', 'Szybka i wygodna dostawa kurierem InPost pod wskazany adres, prosto do domu lub biura.', 'Grafiki/Metody wysyłki/InPost kurier.png', 17.00, 100.00),
(3, 'InPost paczkomat', 'Wygodna i szybka dostawa do paczkomatu – odbierz paczkę w dogodnym dla Ciebie miejscu i czasie.', 'Grafiki/Metody wysyłki/InPost paczkomat.png', 14.00, 100.00);

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

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`Produkt_id`, `Kategoria_id`, `Nazwa`, `Opis`, `Cena`, `Stan_magazynowy`, `Dostepnosc`, `Data_dodania`) VALUES
(1, 1, 'Bluza oversize – beżowa', 'Miękka, wygodna i stylowa – nasza beżowa bluza oversize otula komfortem i świetnie pasuje do codziennych stylizacji. Luźny krój i subtelne detale sprawiają, że wygląda równie dobrze w domu, jak na ulicy.', 100.00, 10, 10, '2026-01-20 17:23:01'),
(3, 1, 'Bluza z kapturem ZIP – limited edition', 'Wyjątkowa bluza z kapturem w edycji limitowanej, łącząca komfort i nowoczesny design. Zamek błyskawiczny i przemyślane detale nadają jej charakteru, a miękka tkanina sprawia, że nosi się ją z przyjemnością na co dzień.', 200.00, 10, 10, '2026-01-20 17:30:10'),
(4, 1, 'Bluza z logo - czarna', 'Klasyczna czarna bluza z subtelnym logo – idealna na co dzień. Minimalistyczny design i miękka tkanina gwarantują wygodę i styl w każdej sytuacji.', 75.00, 10, 10, '2026-01-20 17:31:56'),
(5, 1, 'Koszulka basic – biała', 'Klasyczna biała koszulka, która pasuje do wszystkiego. Miękka, wygodna i ponadczasowa – must-have w każdej garderobie.', 100.00, 10, 10, '2026-01-20 17:32:44'),
(6, 1, 'Koszulka z nadrukiem – retro', 'Stylowa koszulka z unikatowym, retro nadrukiem, która doda charakteru każdej stylizacji. Miękka i wygodna – idealna na co dzień.', 125.00, 10, 10, '2026-01-20 17:33:44'),
(7, 3, 'Kubek termiczny', 'Twój ulubiony napój zawsze w idealnej temperaturze. Stylowy, poręczny i szczelny – idealny do domu, biura i w podróży.', 119.00, 10, 10, '2026-01-20 17:35:03'),
(8, 3, 'Kubek z logo', 'Stylowy kubek z wyraźnym logo, idealny do domu, biura i w podróży. Poręczny, trwały i wygodny w użyciu.', 89.00, 10, 10, '2026-01-20 17:36:10'),
(9, 3, 'Naklejki (zestaw 5 szt.)', 'Zestaw 5 kreatywnych naklejek, które dodadzą charakteru Twoim notatkom, laptopowi lub innym przedmiotom. Wytrzymałe i łatwe w użyciu.', 39.00, 10, 10, '2026-01-20 17:37:00'),
(10, 3, 'Notes z logo', 'Praktyczny notes z eleganckim logo – idealny do notatek w pracy, szkole i w domu. Miękka oprawa i poręczny format ułatwiają codzienne korzystanie.', 49.00, 10, 10, '2026-01-20 17:38:00'),
(11, 3, 'Smycz reklamowa', 'Praktyczna smycz z nadrukiem – idealna do kluczy, identyfikatorów i gadżetów promocyjnych. Wytrzymała i wygodna w codziennym użyciu.', 19.00, 10, 10, '2026-01-20 17:38:55'),
(12, 2, 'Brelok metalowy premium', 'Elegancki brelok wykonany z trwałego metalu – stylowy dodatek do kluczy lub torby. Solidny, wytrzymały i premium w każdym detalu.', 59.00, 10, 10, '2026-01-20 17:41:07'),
(13, 2, 'Brelok z logo', 'Praktyczny brelok z wyraźnym logo – idealny do kluczy lub jako gadżet promocyjny. Lekki, trwały i stylowy.', 39.00, 10, 10, '2026-01-20 17:42:32'),
(14, 2, 'Czapka beanie – szara', 'Miękka i ciepła czapka beanie w uniwersalnym szarym kolorze – idealna na chłodniejsze dni. Stylowa, wygodna i ponadczasowa.', 79.00, 10, 10, '2026-01-20 17:43:32'),
(15, 2, 'Czapka z daszkiem – czarna', 'Klasyczna czapka z daszkiem w eleganckiej czerni – idealna do codziennych stylizacji. Lekka, wygodna i uniwersalna.', 89.00, 10, 10, '2026-01-20 17:44:20'),
(16, 2, 'Torba materiałowa', 'Praktyczna i ekologiczna torba materiałowa – idealna na zakupy, do szkoły czy na co dzień. Lekka, wytrzymała i łatwa w przechowywaniu.', 49.00, 10, 10, '2026-01-20 17:45:09');

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
-- Dumping data for table `zdjecia_produktow`
--

INSERT INTO `zdjecia_produktow` (`Zdjecie_produktu_id`, `Produkt_id`, `Sciezka_do_zdjecia`) VALUES
(1, 1, 'Grafiki/Produkty/Bluza oversize – beżowa.png'),
(3, 3, 'Grafiki/Produkty/Bluza z kapturem ZIP – limited edition.png'),
(4, 4, 'Grafiki/Produkty/Bluza z logo - czarna.png'),
(5, 5, 'Grafiki/Produkty/Koszulka basic – biała.png'),
(6, 6, 'Grafiki/Produkty/Koszulka z nadrukiem – retro.png'),
(7, 7, 'Grafiki/Produkty/Kubek termiczny.png'),
(8, 8, 'Grafiki/Produkty/Kubek z logo.png'),
(9, 9, 'Grafiki/Produkty/Naklejki (zestaw 5 szt.).png'),
(10, 10, 'Grafiki/Produkty/Notes z logo.png'),
(11, 11, 'Grafiki/Produkty/Smycz reklamowa.png'),
(12, 12, 'Grafiki/Produkty/Brelok metalowy premium.png'),
(13, 13, 'Grafiki/Produkty/Brelok z logo.png'),
(14, 14, 'Grafiki/Produkty/Czapka beanie – szara.png'),
(15, 15, 'Grafiki/Produkty/Czapka z daszkiem – czarna.png'),
(16, 16, 'Grafiki/Produkty/Torba materiałowa.png');

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
  MODIFY `Kategoria_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `Klient_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `koszyki`
--
ALTER TABLE `koszyki`
  MODIFY `Koszyk_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metody_platnosci`
--
ALTER TABLE `metody_platnosci`
  MODIFY `Metoda_platnosci_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `metody_wysylki`
--
ALTER TABLE `metody_wysylki`
  MODIFY `Metoda_wysylki_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `Produkt_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `Zamowienie_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zdjecia_produktow`
--
ALTER TABLE `zdjecia_produktow`
  MODIFY `Zdjecie_produktu_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
