<?php 
    require 'Config.php';
    session_start();
    
    if (!isset($_SESSION['Klient'])) 
    {
        header("Location: zaloguj_sie.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - produkt</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/produkt.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amarante&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <img src="../Grafiki/Baner.png" alt="Baner o treści: Piechnikovsky STORE" id="Zdjecie_banera">
        <nav id="Nawigacja">
            <ul id="Lista">
                <li id="Element_listy"><a href="index.php"><img src="../Grafiki/Ikonki/Index.png" alt=""> Index</a></li>
                <li id="Element_listy"><a href="kategorie.php"><img src="../Grafiki/Ikonki/Kategorie.png" alt=""> Kategorie</a></li>
                <li id="Element_listy"><a href="koszyk.php"><img src="../Grafiki/Ikonki/Koszyk.png" alt=""> Koszyk</a></li>
                <li id="Element_listy"><a href="konto.php"><img src="../Grafiki/Ikonki/Konto.png" alt=""> Konto</a></li>
            </ul>
        </nav>
    </header>
    <main id="Strona_glowna">
        <?php
            $Produkt_id = (int)$_GET['id'];

            $stmt = $connect->prepare("SELECT p.*, z.Sciezka_do_zdjecia, k.Nazwa AS Nazwa_kategorii From `produkty` p Join `zdjecia_produktow` z ON z.Produkt_id = p.Produkt_id JOIN `kategorie` k ON k.Kategoria_id = p.Kategoria_id WHERE p.Produkt_id = ?");
            $stmt->bind_param("i", $Produkt_id);
            $stmt->execute();
            $Produkt = $stmt->get_result();
            $Produkt = $Produkt->fetch_assoc();

            $Kwota_darmowej_dostawy = $connect->query("SELECT `Kwota` FROM `kwoty_darmowej_dostawy` WHERE `Kwota_darmowej_dostawy_id` = 1");
            $Kwota_darmowej_dostawy = $Kwota_darmowej_dostawy->fetch_assoc();
            $Kwota_darmowej_dostawy = $Kwota_darmowej_dostawy['Kwota'];

            echo "<section id='Produkt'>";
                echo "<section id='Zdjecie'>";
                    echo "<img src='../".htmlspecialchars($Produkt['Sciezka_do_zdjecia'], ENT_QUOTES, 'UTF-8')."' alt='".htmlspecialchars($Produkt['Nazwa'], ENT_QUOTES, 'UTF-8')."'>";
                echo "</section>";
                echo "<section id='Produkt_info'>";
                    echo "<h1 id='".htmlspecialchars($Produkt['Produkt_id'], ENT_QUOTES, 'UTF-8')."'>".htmlspecialchars($Produkt['Nazwa'], ENT_QUOTES, 'UTF-8')."</h1>";
                    echo "<h1 id='Opis_produktu'>".htmlspecialchars($Produkt['Opis'], ENT_QUOTES, 'UTF-8')."</h1>";
                    echo "<h1 id='Cena_produktu'>".htmlspecialchars($Produkt['Cena'], ENT_QUOTES, 'UTF-8')." zł</h1>";
                    echo "<h3 id='Stan_magazynowy_produktu'>Stan magazynowy: ".htmlspecialchars($Produkt['Stan_magazynowy'], ENT_QUOTES, 'UTF-8')." sztuk</h3>";
                    echo "<h3 id='Dostepnosc_produktu'>Dostępność: ".htmlspecialchars($Produkt['Dostepnosc'], ENT_QUOTES, 'UTF-8')." sztuk</h3>";
                    echo "<h3 id='Data_dodania_produktu'>Data dodania: ".htmlspecialchars($Produkt['Data_dodania'], ENT_QUOTES, 'UTF-8')."</h3>";
                    echo "<h3 id='Kategoria_produktu'>Kategoria: ".htmlspecialchars($Produkt['Nazwa_kategorii'], ENT_QUOTES, 'UTF-8')."</h3>";
                    echo "<form method='post' action='dodaj_do_koszyka.php'>";
                        echo "<input type='hidden' name='Produkt_id' value='".htmlspecialchars($Produkt['Produkt_id'], ENT_QUOTES, 'UTF-8')."'>";
                        echo "<label>Ilość:";
                            echo "<input type='number' name='Ilosc_sztuk' id='Ilosc_sztuk' value='1' min='1' max='".htmlspecialchars($Produkt['Stan_magazynowy'], ENT_QUOTES, 'UTF-8')."'>";
                        echo "</label>";
                        echo "<button type='submit'>Dodaj do koszyka</button>";
                        echo "<p id='Dostawa'><img src='../Grafiki/Ikonki/Dostawa.png' alt=''> Darmowa dostawa od: ".htmlspecialchars($Kwota_darmowej_dostawy, ENT_QUOTES, 'UTF-8')." zł</p>";
                    echo "</form>";
                echo "</section>";
            echo "</section>";
            echo "<section id='Opinie'>";
                echo "<h2>Opinie na temat tego produktu: </h2>";

                $stmt = $connect->prepare("SELECT o.*, k.Imie, k.Nazwisko FROM `opinie` o JOIN `klienci` k ON o.Klient_id = k.Klient_id WHERE `Produkt_id` = ?");
                $stmt->bind_param("i", $Produkt_id);
                $stmt->execute();
                $Opinie = $stmt->get_result();
                
                while ($Opinia = $Opinie->fetch_assoc())
                {
                    $Imie = $Opinia['Imie'];
                    $Nazwisko = $Opinia['Nazwisko'];
                    $Ocena = (int)$Opinia['Ocena'];
                    $Komentarz = $Opinia['Komentarz'];
                    $Data_dodania = $Opinia['Data_dodania'];

                    if ($Ocena > 5)
                    {
                        echo "<section id='Opinia' style='background-color: lightgreen;'>";
                            echo "<p>Autor: ".htmlspecialchars($Imie, ENT_QUOTES, 'UTF-8')." ".htmlspecialchars($Nazwisko, ENT_QUOTES, 'UTF-8')."</p>";
                            echo "<p>Ocena: ".htmlspecialchars($Ocena, ENT_QUOTES, 'UTF-8')." / 10</p>";
                            echo "<p>Komentarz: ".htmlspecialchars($Komentarz, ENT_QUOTES, 'UTF-8')."</p>";
                            echo "<p>Data dodania: ".htmlspecialchars($Data_dodania, ENT_QUOTES, 'UTF-8')."</p>";
                        echo "</section>";
                    }
                    else
                    {
                        echo "<section id='Opinia' style='background-color: lightcoral;'>";
                            echo "<p>Autor: ".htmlspecialchars($Imie, ENT_QUOTES, 'UTF-8')." ".htmlspecialchars($Nazwisko, ENT_QUOTES, 'UTF-8')."</p>";
                            echo "<p>Ocena: ".htmlspecialchars($Ocena, ENT_QUOTES, 'UTF-8')." / 10</p>";
                            echo "<p>Komentarz: ".htmlspecialchars($Komentarz, ENT_QUOTES, 'UTF-8')."</p>";
                            echo "<p>Data dodania: ".htmlspecialchars($Data_dodania, ENT_QUOTES, 'UTF-8')."</p>";
                        echo "</section>";
                    }
                }
            echo "</section>";
        ?>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>