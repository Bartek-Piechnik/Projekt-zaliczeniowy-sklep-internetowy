<?php
    require '../Config.php';
    session_start();
    
    if (!isset($_SESSION['Czy_admin']) || $_SESSION['Czy_admin'] != 1)
    {
        header("Location: ../zaloguj_sie.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - ADMIN zamówienia</title>
    <link rel="icon" type="image/x-icon" href="../../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../../CSS/Admin/glowny.css">
    <link rel="stylesheet" href="../../CSS/Admin/wspolne_tabele.css">
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
        <h1>Co chcesz zrobić:</h1>
        <ul id="Lista_2">
            <li id="Element_listy_2"><a href="modyfikuj_zamowienia.php"><img src="../../Grafiki/Ikonki/Admin/Modyfikuj.png" alt=""> Modyfikuj zamówienia</a></li>
            <li id="Element_listy_2"><a href="usun_zamowienia.php"><img src="../../Grafiki/Ikonki/Admin/Usuń.png" alt=""> Usuń zamówienia</a></li>
        </ul>
        <h1>Aktualna tabela zamówienia:</h1>
        <table>
            <?php
                echo "<tr>";
                    echo "<th>Zamówienie id</th>";
                    echo "<th>Pozycja zamówienia id</th>";
                    echo "<th>Klient id</th>";
                    echo "<th>Nazwa metody wysyłki</th>";
                    echo "<th>Nazwa metody płatności</th>";
                    echo "<th>Kwota łączna</th>";
                    echo "<th>Status</th>";
                    echo "<th>Data zamówienia</th>";
                    echo "<th>Nazwa produktu</th>";
                    echo "<th>Ilość</th>";
                    echo "<th>Cena jednostkowa</th>";
                echo "</tr>";
                $Pozycje_zamowienia = $connect->query("SELECT pz.*, z.*, k.Klient_id, mw.Nazwa AS Nazwa_metody_wysylki, mp.Nazwa AS Nazwa_metody_platnosci, s.Nazwa AS Nazwa_statusu, p.*  From `pozycje_zamowienia` pz JOIN `zamowienia` z ON pz.Zamowienia_id = z.Zamowienie_id JOIN `klienci` k ON z.Klient_id = k.Klient_id JOIN `metody_wysylki` mw ON z.Metody_wysylki_id = mw.Metoda_wysylki_id JOIN `metody_platnosci` mp ON z.Metody_platnosci_id = mp.Metoda_platnosci_id JOIN `statusy` s ON z.Status_id = s.Status_id JOIN `produkty` p ON pz.Produkty_id = p.Produkt_id");
                while ($Pozycja_zamowienia = $Pozycje_zamowienia->fetch_assoc())
                {
                    echo "<tr>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Zamowienie_id'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Pozycja_zamowienia_id'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Klient_id'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Nazwa_metody_wysylki'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Nazwa_metody_platnosci'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Kwota_laczna'], ENT_QUOTES, 'UTF-8')." zł</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Nazwa_statusu'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Data_zamowienia'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Nazwa'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Ilosc'], ENT_QUOTES, 'UTF-8')." szt.</td>";
                        echo "<td>".htmlspecialchars($Pozycja_zamowienia['Cena_jednostkowa'], ENT_QUOTES, 'UTF-8')." zł</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>