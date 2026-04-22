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
        if (empty($_POST['Kwota_darmowej_dostawy'])) 
        {
            $Bledy[] = "Nie podano kwoty darmowej dostawy.";
        }

        if (empty($Bledy))
        {
            $Kwota_darmowej_dostawy = $_POST['Kwota_darmowej_dostawy'];

            $stmt = $connect->prepare("INSERT INTO `kwoty_darmowej_dostawy` (`Kwota`) VALUES (?);");
            $stmt->bind_param("d", $Kwota_darmowej_dostawy);
            $stmt->execute();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - ADMIN dodaj kwoty darmowej dostawy</title>
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
                <li id="Element_listy_1"><a href="kwoty_darmowej_dostawy.php"><img src="../../Grafiki/Ikonki/Admin/Kwoty darmowej dostawy.png" alt=""> Kwoty darmowej dostawy</a></li>
                <li id="Element_listy_1"><a href="klienci.php"><img src="../../Grafiki/Ikonki/Admin/Klienci.png" alt=""> Klienci</a></li>
                <li id="Element_listy_1"><a href="zamowienia.php"><img src="../../Grafiki/Ikonki/Admin/Zamówienia.png" alt=""> Zamówienia</a></li>
            </ul>
        </nav>
        <button type="submit" id="Wyloguj"><a href="../wyloguj.php">Wyloguj</a></button>
    </header>
    <main id="Strona_glowna">
        <h2>Dodaj kwoty darmowej dostawy:</h2>
        <?php 
            if (!empty($Bledy)) 
            { 
                foreach ($Bledy as $Blad) 
                { 
                    echo "<p style='color:red;'>".htmlspecialchars($Blad, ENT_QUOTES, 'UTF-8')."</p>"; 
                } 
            }
        ?>
        <form action="dodaj_kwoty_darmowej_dostawy.php" id="Formularz" method="post">
            <label for="Kwota_darmowej_dostawy">
                Kwota darmowej dostawy: <input type="number" name="Kwota_darmowej_dostawy" id="Kwota_darmowej_dostawy" maxlength="12">
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