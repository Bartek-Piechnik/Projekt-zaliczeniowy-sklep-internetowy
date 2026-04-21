<?php 
    require 'Config.php';
    session_start();
    
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
    if (!isset($_SESSION['Ostatnie_zamowienie_id']))
    {
        header("Location: kategorie.php");
        exit;
    }    
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - potwierdzenie</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/potwierdzenie.css">
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
        <h2 id="Potwierdzenie">Potwierdzenie:</h2>
        <section id="Lista_produktow">
            <?php
                $Zamowienie_id = $_SESSION['Ostatnie_zamowienie_id'];

                $stmt = $connect->prepare("SELECT p.Nazwa, pz.Ilosc, pz.Cena_jednostkowa, z.Sciezka_do_zdjecia FROM `pozycje_zamowienia` pz JOIN `produkty` p ON p.Produkt_id = pz.Produkty_id LEFT JOIN `zdjecia_produktow` z ON z.Produkt_id = p.Produkt_id WHERE pz.Zamowienia_id = ?");
                $stmt->bind_param("i", $Zamowienie_id);
                $stmt->execute();
                $Produkty = $stmt->get_result();

                $Cena_produktow = 0;
                
                while ($Produkt = $Produkty->fetch_assoc())
                {
                    $Kwota_laczna = $Produkt['Ilosc'] * $Produkt['Cena_jednostkowa'];
                    echo "<section id='Produkt'>";
                        echo "<img src='../".htmlspecialchars($Produkt['Sciezka_do_zdjecia'], ENT_QUOTES, 'UTF-8')."' alt='".htmlspecialchars($Produkt['Nazwa'], ENT_QUOTES, 'UTF-8')."' id='Zdjecie'>";
                        echo "<p>Ilość: ".htmlspecialchars($Produkt['Ilosc'], ENT_QUOTES, 'UTF-8')." szt.</p>";
                        echo "<p>Cena: ".htmlspecialchars($Produkt['Cena_jednostkowa'], ENT_QUOTES, 'UTF-8')." zł</p>";
                        echo "<p>Kwota łączna: ".$Kwota_laczna." zł</p>";
                    echo "</section>";
                    $Cena_produktow = $Cena_produktow + $Kwota_laczna;
                }

                $stmt = $connect->prepare("SELECT z.Metody_wysylki_id, mw.Koszt, mw.Darmowa_od FROM `zamowienia` z JOIN `metody_wysylki` mw ON mw.Metoda_wysylki_id = z.Metody_wysylki_id WHERE z.Zamowienie_id = ?");
                $stmt->bind_param("i", $Zamowienie_id);
                $stmt->execute();
                $Zamowienie = $stmt->get_result();
                $Zamowienie = $Zamowienie->fetch_assoc();
                
                $Cena_wysylki = $Zamowienie['Koszt'];
                $Darmowa_od = $Zamowienie['Darmowa_od'];
            ?>
            <table>
                <tr>
                    <td>Produkty:</td>
                    <td><?php echo $Cena_produktow ?> zł</td>
                </tr>
                <tr>
                    <td>Wysyłka:</td>
                    <?php
                        if ($Cena_produktow >= $Darmowa_od)
                        {
                            $Cena_wysylki = 0;
                        }
                        else
                        {
                            $Cena_wysylki;
                        }
                    ?>
                    <td><?php echo $Cena_wysylki ?> zł</td>
                </tr>
            </table>
            <h1>Razem (brutto): <?php echo ($Cena_produktow + $Cena_wysylki)?> zł</h1>
        </section>
        <h1>Podziel się swoją opinią!</h1>
        <a href="opinia.php">Dodaj opinię</a>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>