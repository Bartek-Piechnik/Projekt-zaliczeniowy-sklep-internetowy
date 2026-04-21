<?php
    require '../Config.php';
    session_start();
    $Bledy = [];
    
    if (!isset($_SESSION['Czy_admin']) || $_SESSION['Czy_admin'] != 1) 
    {
        header("Location: ../zaloguj_sie.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (empty($_POST['Klient_id'])) 
        {
            $Bledy[] = "Nie podano Id klienta.";
        }
        if (empty($_POST['Imie_klienta'])) 
        {
            $Bledy[] = "Nie podano imienia klienta.";
        }
        if (empty($_POST['Nazwisko_klienta'])) 
        {
            $Bledy[] = "Nie podano nazwiska klienta.";
        }
        if (empty($_POST['E-mail_klienta'])) 
        {
            $Bledy[] = "Nie podano e-mail'a klienta.";
        }
        if (empty($_POST['Telefon_klienta'])) 
        {
            $Bledy[] = "Nie podano telefonu klienta.";
        }
        if (empty($_POST['Haslo_klienta'])) 
        {
            $Bledy[] = "Nie podano hasła klienta.";
        }
        if (empty($_POST['Miasto_klienta'])) 
        {
            $Bledy[] = "Nie podano miasta klienta.";
        }
        if (empty($_POST['Ulica_klienta'])) 
        {
            $Bledy[] = "Nie podano ulicy klienta.";
        }
        if (empty($_POST['Numer_domu_mieszkania_klienta'])) 
        {
            $Bledy[] = "Nie podano numeru domu/mieszkania klienta.";
        }
        if (empty($_POST['Kod_pocztowy_klienta'])) 
        {
            $Bledy[] = "Nie podano kodu pocztowego klienta.";
        }

        if (empty($Bledy))
        {
            $Klient_id = (int)$_POST['Klient_id'];
            $Imie_klienta = $_POST['Imie_klienta'];
            $Nazwisko_klienta = $_POST['Nazwisko_klienta'];
            $Email_klienta = $_POST['E-mail_klienta'];
            $Telefon_klienta = $_POST['Telefon_klienta'];
            $Haslo_klienta = password_hash($_POST['Haslo_klienta'], PASSWORD_DEFAULT);
            $Miasto_klienta = $_POST['Miasto_klienta'];
            $Ulica_klienta = $_POST['Ulica_klienta'];
            $Numer_domu_mieszkania_klienta = $_POST['Numer_domu_mieszkania_klienta'];
            $Kod_pocztowy_klienta = $_POST['Kod_pocztowy_klienta'];
            $Wojewodztwo_id = (int)$_POST['Wojewodztwo_id'];
            $Czy_admin = 0;

            $stmt = $connect->prepare("SELECT `Adres_id` FROM `klienci` WHERE `Klient_id` = ?");
            $stmt->bind_param("i", $Klient_id);
            $stmt->execute();
            $Adres_id = $stmt->get_result();
            $Adres_id = $Adres_id->fetch_assoc();
            $Adres_id = $Adres_id['Adres_id'];

            $stmt = $connect->prepare("UPDATE `adresy` SET `Miasto` = ?, `Ulica` = ?, `Numer_domu_mieszkania` = ?, `Kod_pocztowy` = ?, `Wojewodztwo_id` = ? WHERE `Adres_id` = ?;");
            $stmt->bind_param("ssssii", $Miasto_klienta, $Ulica_klienta, $Numer_domu_mieszkania_klienta, $Kod_pocztowy_klienta, $Wojewodztwo_id, $Adres_id);
            $stmt->execute();
            
            $stmt = $connect->prepare("UPDATE `klienci` SET `Imie` = ?, `Nazwisko` = ?, `E-mail` = ?, `Telefon` = ?, `Haslo` = ?, `Czy_admin` = ? WHERE `Klient_id` = ?;");
            $stmt->bind_param("sssssii", $Imie_klienta, $Nazwisko_klienta, $Email_klienta, $Telefon_klienta, $Haslo_klienta, $Czy_admin, $Klient_id);
            $stmt->execute();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - ADMIN modyfikuj klientów</title>
    <link rel="icon" type="image/x-icon" href="../../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../../CSS/Admin/glowny.css">
    <link rel="stylesheet" href="../../CSS/Admin/wspolne_formularze.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amarante&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <img src="../../Grafiki/Baner.png" alt="Baner o treści: Piechnikovsky STORE" id="Zdjecie_banera">
        <nav id="Nawigacja">
            <h1>Strona administracyjna</h1>
            <ul id="Lista_1">
                <li id="Element_listy_1"><a href="kategorie.php"><img src="../../Grafiki/Ikonki/Admin/Kategorie.png" alt=""> Kategorie</a></li>
                <li id="Element_listy_1"><a href="produkty.php"><img src="../../Grafiki/Ikonki/Admin/Produkty.png" alt=""> Produkty</a></li>
                <li id="Element_listy_1"><a href="zdjecia.php"><img src="../../Grafiki/Ikonki/Admin/Zdjęcia.png" alt=""> Zdjęcia</a></li>
                <li id="Element_listy_1"><a href="metody_platnosci.php"><img src="../../Grafiki/Ikonki/Admin/Metody płatności.png" alt=""> Metody płatności</a></li>
                <li id="Element_listy_1"><a href="metody_wysylki.php"><img src="../../Grafiki/Ikonki/Admin/Metody wysyłki.png" alt=""> Metody wysyłki</a></li>
                <li id="Element_listy_1"><a href="klienci.php"><img src="../../Grafiki/Ikonki/Admin/Klienci.png" alt=""> Klienci</a></li>
                <li id="Element_listy_1"><a href="zamowienia.php"><img src="../../Grafiki/Ikonki/Admin/Zamówienia.png" alt=""> Zamówienia</a></li>
            </ul>
        </nav>
        <button type="submit" id="Wyloguj"><a href="../wyloguj.php">Wyloguj</a></button>
    </header>
    <main id="Strona_glowna">
        <h2>Modyfikuj klientów:</h2>
        <?php 
            if (!empty($Bledy)) 
            {
                foreach ($Bledy as $Blad) 
                {
                    echo "<p style='color:red;'>$Blad</p>";
                }
            }
        ?>
        <form action="modyfikuj_klientow.php" id="Formularz" method="post">
            <label for="Klient_id">
                Id klienta: <input type="number" name="Klient_id" id="Klient_id">
            </label>
            <label for="Imie_klienta">
                Imię klienta: <input type="text" name="Imie_klienta" id="Imie_klienta" maxlength="50">
            </label>
            <label for="Nazwisko_klienta">
                Nazwisko klienta: <input type="text" name="Nazwisko_klienta" id="Nazwisko_klienta" maxlength="50">
            </label>
            <label for="E-mail_klienta">
                E-mail klienta: <input type="email" name="E-mail_klienta" id="E-mail_klienta" maxlength="100">
            </label>
            <label for="Telefon_klienta">
                Telefon klienta: <input type="tel" name="Telefon_klienta" id="Telefon_klienta" maxlength="20">
            </label>
            <label for="Haslo_klienta">
                Hasło klienta: <input type="password" name="Haslo_klienta" id="Haslo_klienta" maxlength="255">
            </label>
            <label for="Miasto_klienta">
                Miasto klienta: <input type="text" name="Miasto_klienta" id="Miasto_klienta" maxlength="100">
            </label>
            <label for="Ulica_klienta">
                Ulica klienta: <input type="text" name="Ulica_klienta" id="Ulica_klienta" maxlength="100">
            </label>
            <label for="Numer_domu_mieszkania_klienta">
                Numer domu/mieszkania klienta: <input type="text" name="Numer_domu_mieszkania_klienta" id="Numer_domu_mieszkania_klienta" maxlength="10">
            </label>
            <label for="Kod_pocztowy_klienta">
                Kod pocztowy klienta: <input type="text" name="Kod_pocztowy_klienta" id="Kod_pocztowy_klienta" maxlength="6">
            </label>
            <label for="Wojewodztwo_id">
                    Województwo klienta:
                    <select name="Wojewodztwo_id" id="Wojewodztwo_id">
                        <?php
                            $Wojewodztwa = $connect->query("SELECT * From `wojewodztwa`");
                            while ($Wojewodztwo = $Wojewodztwa->fetch_assoc())
                            {
                                echo "<option value='".htmlspecialchars($Wojewodztwo['Wojewodztwo_id'], ENT_QUOTES, 'UTF-8')."'>".htmlspecialchars($Wojewodztwo['Nazwa'], ENT_QUOTES, 'UTF-8')."</option>";
                            }
                        ?> 
                    </select>
            </label>
            <button type="submit">Modyfikuj</button>
        </form>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>