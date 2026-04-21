<?php
    require 'Config.php';
    session_start();
    $ID_sesji = session_id();

    if (!isset($_SESSION['Klient'])) 
    {
        header("Location: zaloguj_sie.php");
        exit;
    }
    if (!isset($_SESSION['Metody_wysylki_id'])) 
    {
        header("Location: zamowienie.php");
        exit;
    }
    if (!isset($_SESSION['Metoda_platnosci_id'])) 
    {
        header("Location: platnosc.php");
        exit;
    }

    $Email = $_SESSION['Klient'];

    $stmt = $connect->prepare("SELECT `Klient_id` FROM `klienci` WHERE `E-mail` = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $Klient_id = $stmt->get_result();
    $Klient_id = $Klient_id->fetch_assoc();
    $Klient_id = (int)$Klient_id['Klient_id'];

    $Metody_wysylki_id = $_SESSION['Metody_wysylki_id'];
    $Metody_platnosci_id = $_SESSION['Metoda_platnosci_id'];
    $Cena_calkowita = $_SESSION['Cena_calkowita'];

    $stmt = $connect->prepare("SELECT `Koszt` From `metody_wysylki` WHERE `Metoda_wysylki_id` = ?");
    $stmt->bind_param("i", $Metody_wysylki_id);
    $stmt->execute();
    $Koszt_metody_wysylki = $stmt->get_result();
    $Koszt_metody_wysylki = $Koszt_metody_wysylki->fetch_assoc();
    $Kwota_laczna = $Cena_calkowita + $Koszt_metody_wysylki['Koszt'];

    $Status_id = $connect->query("SELECT `Status_id` FROM `statusy` WHERE `Status_id` = 1");
    $Status_id = $Status_id->fetch_assoc();
    $Status_id = (int)$Status_id['Status_id'];

    $stmt = $connect->prepare("INSERT INTO `zamowienia` (`Klient_id`, `Metody_wysylki_id`, `Metody_platnosci_id`, `Kwota_laczna`, `Status_id`) VALUES (?, ?, ?, ?, ?);");
    $stmt->bind_param("iiidi", $Klient_id, $Metody_wysylki_id, $Metody_platnosci_id, $Kwota_laczna, $Status_id);
    $stmt->execute();
    $Zamowienia_id = $connect->insert_id;
    
    $stmt = $connect->prepare("SELECT `Koszyk_id` FROM `koszyki` WHERE `id_sesji` = ?");
    $stmt->bind_param("s", $ID_sesji);
    $stmt->execute();
    $Koszyk_id = $stmt->get_result();
    $Koszyk_id = $Koszyk_id->fetch_assoc();
    $Koszyk_id = (int)$Koszyk_id['Koszyk_id'];

    $stmt = $connect->prepare("SELECT pk.*, p.* FROM `pozycje_koszyka` pk JOIN `produkty` p ON pk.Produkt_id = p.Produkt_id WHERE pk.Koszyk_id = ?");
    $stmt->bind_param("i", $Koszyk_id);
    $stmt->execute();
    $Produkty = $stmt->get_result();

    while ($Produkt = $Produkty->fetch_assoc())
    {
        $Produkt_id = (int)$Produkt['Produkt_id'];
        $Ilosc = (int)$Produkt['Ilosc'];
        $Cena = $Produkt['Cena'];

        $stmt = $connect->prepare("INSERT INTO `pozycje_zamowienia` (`Zamowienia_id`, `Produkty_id`, `Ilosc`, `Cena_jednostkowa`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $Zamowienia_id, $Produkt_id, $Ilosc, $Cena);
        $stmt->execute();
        
        $stmt = $connect->prepare("UPDATE `produkty` SET `Stan_magazynowy` = `Stan_magazynowy` - ? WHERE `Produkt_id` = ?");
        $stmt->bind_param("ii", $Ilosc, $Produkt_id);
        $stmt->execute();
    }
    $stmt = $connect->prepare("DELETE FROM `pozycje_koszyka` WHERE `Koszyk_id` = ?");
    $stmt->bind_param("i", $Koszyk_id);
    $stmt->execute();
    $_SESSION['Ostatnie_zamowienie_id'] = (int)$Zamowienia_id;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - Zakończenie płatności</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/zakonczenie_platnosci.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amarante&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <img src="../Grafiki/Baner.png" alt="Baner o treści: Piechnikovsky STORE" id="Zdjecie_banera">
        <nav id="Nawigacja">
            <ul id="Lista">
                <li id="Element_listy"><a href="kategorie.php"><img src="../Grafiki/Ikonki/Kategorie.png" alt=""> Kategorie</a></li>
                <li id="Element_listy"><a href="koszyk.php"><img src="../Grafiki/Ikonki/Koszyk.png" alt=""> Koszyk</a></li>
                <li id="Element_listy"><a href="zamowienie.php"><img src="../Grafiki/Ikonki/Zamówienie.png" alt=""> Zamówienie</a></li>
                <li id="Element_listy"><a href="konto.php"><img src="../Grafiki/Ikonki/Konto.png" alt=""> Konto</a></li>
            </ul>
        </nav>
    </header>
    <main id="Strona_glowna">
        <h1>Zamówienie złożone pomyślnie!</h1>
        <a href="potwierdzenie.php">Potwierdzenie zamówienia</a>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>