<?php
    require '../Config.php';
    session_start();
    
    if (!isset($_SESSION['Czy_admin']) || $_SESSION['Czy_admin'] != 1) 
    {
        header("Location: ../zaloguj_sie.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $Klient_id = (int)$_POST['Klient_id'];

        $stmt = $connect->prepare("SELECT `Adres_id` FROM `klienci` WHERE `Klient_id` = ?");
        $stmt->bind_param("i", $Klient_id);
        $stmt->execute();
        $Adres_id = $stmt->get_result();
        $Adres_id = $Adres_id->fetch_assoc();
        $Adres_id = (int)$Adres_id['Adres_id'];
        
        $stmt = $connect->prepare("DELETE FROM `klienci` WHERE `Klient_id` = ?;");
        $stmt->bind_param("i", $Klient_id);
        $stmt->execute();
        
        $stmt = $connect->prepare("DELETE FROM `adresy` WHERE `Adres_id` = ?;");
        $stmt->bind_param("i", $Adres_id);
        $stmt->execute();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - ADMIN usuń klientów</title>
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
        <h2>Usuń klientów:</h2>
        <form action="usun_klientow.php" id="Formularz" method="post">
            <label for="Klient_id">
                Klient:
                <select name="Klient_id" id="Klient_id">
                    <?php
                        $Klienci = $connect->query("SELECT `Klient_id`, `Imie`, `Nazwisko` From `klienci`");
                        while ($Klient = $Klienci->fetch_assoc())
                        {
                            echo "<option value='".htmlspecialchars($Klient['Klient_id'], ENT_QUOTES, 'UTF-8')."'>".htmlspecialchars($Klient['Klient_id'], ENT_QUOTES, 'UTF-8').". ".htmlspecialchars($Klient['Imie'], ENT_QUOTES, 'UTF-8')." ".htmlspecialchars($Klient['Nazwisko'], ENT_QUOTES, 'UTF-8')."</option>";
                        }
                    ?>
                </select>
            </label>
            <button type="submit">Usuń</button>
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