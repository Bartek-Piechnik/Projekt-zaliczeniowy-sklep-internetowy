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
    <title>Piechnikovsky STORE - ADMIN produkty</title>
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
            <li id="Element_listy_2"><a href="dodaj_produkty.php"><img src="../../Grafiki/Ikonki/Admin/Dodaj.png" alt=""> Dodaj produkty</a></li>
            <li id="Element_listy_2"><a href="modyfikuj_produkty.php"><img src="../../Grafiki/Ikonki/Admin/Modyfikuj.png" alt=""> Modyfikuj produkty</a></li>
            <li id="Element_listy_2"><a href="usun_produkty.php"><img src="../../Grafiki/Ikonki/Admin/Usuń.png" alt=""> Usuń produkty</a></li>
        </ul>
        <h1>Aktualna tabela produkty:</h1>
        <table>
            <?php
                echo "<tr>";
                    echo "<th>Produkt id</th>";
                    echo "<th>Kategoria id</th>";
                    echo "<th>Nazwa produktu</th>";
                    echo "<th>Opis produktu</th>";
                    echo "<th>Cena produktu</th>";
                    echo "<th>Stan magazynowy produktu</th>";
                    echo "<th>Dostępność produktu</th>";
                    echo "<th>Data dodania produktu</th>";
                echo "</tr>";
                $Produkty = $connect->query("SELECT * From `produkty`");
                while ($Produkt = $Produkty->fetch_assoc())
                {
                    echo "<tr>";
                        echo "<td>".htmlspecialchars($Produkt['Produkt_id'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Produkt['Kategoria_id'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Produkt['Nazwa'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Produkt['Opis'], ENT_QUOTES, 'UTF-8')."</td>";
                        echo "<td>".htmlspecialchars($Produkt['Cena'], ENT_QUOTES, 'UTF-8')." zł</td>";
                        echo "<td>".htmlspecialchars($Produkt['Stan_magazynowy'], ENT_QUOTES, 'UTF-8')." szt.</td>";
                        echo "<td>".htmlspecialchars($Produkt['Dostepnosc'], ENT_QUOTES, 'UTF-8')." szt.</td>";
                        echo "<td>".htmlspecialchars($Produkt['Data_dodania'], ENT_QUOTES, 'UTF-8')."</td>";
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