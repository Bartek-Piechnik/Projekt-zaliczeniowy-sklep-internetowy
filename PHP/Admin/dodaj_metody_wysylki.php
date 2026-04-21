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
        if (empty($_POST['Nazwa_metody_wysylki'])) 
        {
            $Bledy[] = "Nie podano nazwy metody wysyłki.";
        }
        if (empty($_POST['Opis_metody_wysylki'])) 
        {
            $Bledy[] = "Nie podano opisu metody wysyłki.";
        }
        if (empty($_POST['Koszt_metody_wysylki'])) 
        {
            $Bledy[] = "Nie podano kosztu metody wysyłki.";
        }
        if (empty($_POST['Darmowa_metoda_wysylki_od'])) 
        {
            $Bledy[] = "Nie podano kwoty od której wysyłka jest darmowa.";
        }

        if (empty($Bledy))
        {
            $Nazwa_metody_wysylki = $_POST['Nazwa_metody_wysylki'];
            $Opis_metody_wysylki = $_POST['Opis_metody_wysylki'];
            $Koszt_metody_wysylki = $_POST['Koszt_metody_wysylki'];
            $Darmowa_metoda_wysylki_od = $_POST['Darmowa_metoda_wysylki_od'];
            $Zdjecie_metody_wysylki = $_POST['Zdjecie_metody_wysylki'];

            $stmt = $connect->prepare("INSERT INTO `metody_wysylki` (`Nazwa`, `Opis`, `Zdjecie`, `Koszt`, `Darmowa_od`) VALUES (?, ?, ?, ?, ?);");
            $stmt->bind_param("sssdd", $Nazwa_metody_wysylki, $Opis_metody_wysylki, $Zdjecie_metody_wysylki, $Koszt_metody_wysylki, $Darmowa_metoda_wysylki_od);
            $stmt->execute();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - ADMIN dodaj metody wysyłki</title>
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
        <h2>Dodaj metody wysyłki:</h2>
        <?php 
            if (!empty($Bledy)) 
            {
                foreach ($Bledy as $Blad) 
                {
                    echo "<p style='color:red;'>$Blad</p>";
                }
            }
        ?>
        <form action="dodaj_metody_wysylki.php" id="Formularz" method="post">
            <label for="Nazwa_metody_wysylki">
                Nazwa metody wysyłki: <input type="text" name="Nazwa_metody_wysylki" id="Nazwa_metody_wysylki" maxlength="100">
            </label>
            <label for="Opis_metody_wysylki">
                Opis metody wysyłki: <textarea name="Opis_metody_wysylki" id="Opis_metody_wysylki" maxlength="255"></textarea>
            </label>
            <label for="Koszt_metody_wysylki">
                Koszt metody wysyłki: <input type="number" name="Koszt_metody_wysylki" id="Koszt_metody_wysylki" maxlength="12">
            </label>
            <label for="Darmowa_metoda_wysylki_od">
                Darmowa metoda wysyłki od: <input type="number" name="Darmowa_metoda_wysylki_od" id="Darmowa_metoda_wysylki_od" maxlength="12">
            </label>
             <label for="Zdjecie_metody_wysylki">
                Zdjęcie metody wysyłki:
                <select name="Zdjecie_metody_wysylki">
                    <?php
                        $Pliki = glob('../../Grafiki/Metody wysyłki/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
                        foreach ($Pliki as $Plik) 
                        {
                            $Sciezka_do_bazy = 'Grafiki/Metody wysyłki/' . basename($Plik);
                            echo "<option value='$Sciezka_do_bazy'>$Sciezka_do_bazy</option>";
                        }
                    ?>
                </select>
            </label>
            <button type="submit">Dodaj</button>
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