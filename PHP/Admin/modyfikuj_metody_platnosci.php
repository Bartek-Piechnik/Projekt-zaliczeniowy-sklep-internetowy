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
        if (empty($_POST['Metoda_platnosci_id'])) 
        {
            $Bledy[] = "Nie podano Id metody płatności.";
        }
        if (empty($_POST['Nazwa_metody_platnosci'])) 
        {
            $Bledy[] = "Nie podano nazwy metody płatności.";
        }
        if (empty($_POST['Opis_metody_platnosci'])) 
        {
            $Bledy[] = "Nie podano opisu metody płatności.";
        }

        if (empty($Bledy))
        {
            $Metoda_platnosci_id = (int)$_POST['Metoda_platnosci_id'];
            $Nazwa_metody_platnosci = $_POST['Nazwa_metody_platnosci'];
            $Opis_metody_platnosci = $_POST['Opis_metody_platnosci'];
            $Zdjecie_metody_platnosci = $_POST['Zdjecie_metody_platnosci'];

            $stmt = $connect->prepare("UPDATE `metody_platnosci` SET `Nazwa` = ?, `Opis` = ?, `Zdjecie` = ? WHERE `Metoda_platnosci_id` = ?;");
            $stmt->bind_param("sssi", $Nazwa_metody_platnosci, $Opis_metody_platnosci, $Zdjecie_metody_platnosci, $Metoda_platnosci_id);
            $stmt->execute();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - ADMIN modyfikuj metody płatności</title>
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
        <h2>Modyfikuj metody płatności:</h2>
        <?php 
            if (!empty($Bledy)) 
            {
                foreach ($Bledy as $Blad) 
                {
                    echo "<p style='color:red;'>$Blad</p>";
                }
            }
        ?>
        <form action="modyfikuj_metody_platnosci.php" id="Formularz" method="post">
            <label for="Metoda_platnosci_id">
                Id metody płatności: <input type="number" name="Metoda_platnosci_id" id="Metoda_platnosci_id">
            </label>
            <label for="Nazwa_metody_platnosci">
                Nazwa metody płatności: <input type="text" name="Nazwa_metody_platnosci" id="Nazwa_metody_platnosci" maxlength="100">
            </label>
            <label for="Opis_metody_platnosci">
                Opis metody płatności: <textarea name="Opis_metody_platnosci" id="Opis_metody_platnosci" maxlength="255"></textarea>
            </label>
            <label for="Zdjecie_metody_platnosci">
                Zdjęcie metody płatności:
                <select name="Zdjecie_metody_platnosci">
                    <?php
                        $Pliki = glob('../../Grafiki/Metody płatności/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
                        foreach ($Pliki as $Plik) 
                        {
                            $Sciezka_do_bazy = 'Grafiki/Metody płatności/' . basename($Plik);
                            echo "<option value='$Sciezka_do_bazy'>$Sciezka_do_bazy</option>";
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