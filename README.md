# 🛍️ Piechnikovsky STORE

Prosty sklep internetowy stworzony w ramach projektu zaliczeniowego. Aplikacja pozwala przeglądać ofertę, zarządzać koszykiem i składać zamówienia, a panel administratora umożliwia zarządzanie zawartością sklepu.

## ✨ O projekcie

Sklep oferuje produkty z kategorii **Odzież**, **Akcesoria** i **Gadżety**. Projekt obejmuje zarówno część dla klientów, jak i panel administracyjny.

### Najważniejsze funkcje

- 👕 przeglądanie kategorii i produktów
- 🛒 dodawanie produktów do koszyka i składanie zamówień
- 👤 rejestracja, logowanie i konto klienta
- 🚚 wybór metod dostawy i płatności
- ⭐ dodawanie opinii o produktach
- 🧰 panel administratora do zarządzania produktami, kategoriami, klientami, zamówieniami, zdjęciami i ustawieniami sklepu

## 🧱 Technologie

- **PHP** – logika aplikacji
- **MySQL / MariaDB** – baza danych
- **HTML i CSS** – struktura i wygląd stron
- **XAMPP** – lokalne środowisko serwerowe

## 📋 Wymagania

- Git
- XAMPP z Apache, PHP i MySQL/MariaDB
- Przeglądarka internetowa

## 🚀 Uruchomienie lokalne

Poniższa instrukcja zakłada system Windows i XAMPP zainstalowany w `C:\xampp`.

### 1. Sklonuj repozytorium

Otwórz terminal i przejdź do katalogu `htdocs`:

```bash
cd C:\xampp\htdocs
git clone https://github.com/Bartek-Piechnik/Projekt-zaliczeniowy-sklep-internetowy.git
```

### 2. Uruchom XAMPP

W XAMPP Control Panel uruchom moduły **Apache** i **MySQL**.

### 3. Utwórz i zaimportuj bazę danych

1. Otwórz [phpMyAdmin](http://localhost/phpmyadmin).
2. Utwórz bazę danych o nazwie:

   ```text
   3tpa_2025_-_projekt_zaliczeniowy_(sklep_internetowy)
   ```

3. Wybierz utworzoną bazę i przejdź do zakładki **Import**.
4. Wskaż plik `Baza/Baza danych 22.04.2026/3tpa_2025_-_projekt_zaliczeniowy__sklep_internetowy_ (1).sql` z repozytorium i rozpocznij import.

### 4. Sprawdź konfigurację połączenia

Ustawienia połączenia z bazą znajdują się w [PHP/Config.php](PHP/Config.php). Domyślna konfiguracja dla XAMPP to:

| Ustawienie | Wartość |
|---|---|
| Host | `localhost` |
| Użytkownik | `root` |
| Hasło | puste |
| Baza danych | `3tpa_2025_-_projekt_zaliczeniowy_(sklep_internetowy)` |

Jeśli Twoja konfiguracja MySQL jest inna, zaktualizuj odpowiednie wartości w tym pliku.

### 5. Otwórz sklep

Przejdź pod adres:

```text
http://localhost/Projekt-zaliczeniowy-sklep-internetowy/PHP/konto.php
```

Możesz założyć konto klienta na stronie rejestracji. Dostęp do funkcji administracyjnych wymaga konta z uprawnieniami administratora.

## 📁 Struktura projektu

```text
├── Baza/       # zrzuty bazy danych i diagram
├── CSS/        # arkusze stylów
├── Grafiki/    # banery, ikony i zdjęcia produktów
├── PHP/        # strony sklepu, obsługa logowania i panel Admin
└── README.md
```

## 🎓 Informacja

Projekt ma charakter edukacyjny i został przygotowany jako projekt zaliczeniowy.
