<?php
    require '../../PHP/Config.php';
    session_start();

    if (!isset($_SESSION['Metoda_platnosci_id'])) 
    {
        header("Location: ../platnosc.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        sleep(2);
        header("Location: ../../PHP/zakonczenie_platnosci.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - Blik</title>
    <link rel="icon" type="image/x-icon" href="../../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../../CSS/glowny.css">
    <link rel="stylesheet" href="../../CSS//Admin/wspolne_formularze.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amarante&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <img src="../../Grafiki/Baner.png" alt="Baner o treści: Piechnikovsky STORE" id="Zdjecie_banera">
        <nav id="Nawigacja">
            <ul id="Lista">
                <li id="Element_listy"><a href="kategorie.php"><img src="../../Grafiki/Ikonki/Kategorie.png" alt=""> Kategorie</a></li>
                <li id="Element_listy"><a href="koszyk.php"><img src="../../Grafiki/Ikonki/Koszyk.png" alt=""> Koszyk</a></li>
                <li id="Element_listy"><a href="zamowienie.php"><img src="../../Grafiki/Ikonki/Zamówienie.png" alt=""> Zamówienie</a></li>
                <li id="Element_listy"><a href="konto.php"><img src="../../Grafiki/Ikonki/Konto.png" alt=""> Konto</a></li>
            </ul>
        </nav>
    </header>
    <main id="Strona_glowna">
        <form method="post">
            <h2>Płatność BLIK</h2>
            <img src="../../Grafiki/Metody płatności/Blik.png" width="150">
            <p>Zaloguj się do Blik i potwierdź płatność.</p>
            <label for="Kod_blik">
                Kod Blik: <input type="number" name="Kod_blik" id="Kod_blik" maxlength="6">
            </label>
            <button type="submit">Zapłać przez Blik</button>
        </form>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
</body>
</html>