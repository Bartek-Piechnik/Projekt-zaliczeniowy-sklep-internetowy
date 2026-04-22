<?php
    require 'Config.php';
    session_start();
    $ID_sesji = session_id();

    if (!isset($_SESSION['Klient'])) 
    {
        header("Location: zaloguj_sie.php");
        exit;
    }

    if (isset($_POST['Usun']))
    {
        $Produkt_id = (int)$_POST['Usun'];

        $stmt = $connect->prepare("DELETE pk.* FROM pozycje_koszyka pk JOIN koszyki k ON pk.Koszyk_id = k.Koszyk_id WHERE pk.Produkt_id = ? AND k.id_sesji = ?");
        $stmt->bind_param("is", $Produkt_id, $ID_sesji);
        $stmt->execute();
        
        header("Location: koszyk.php");
        exit;
    }
    
    if (isset($_POST['Przelicz']) && isset($_POST['Ilosc'])) 
    {
        foreach ($_POST['Ilosc'] as $Produkt_id => $Ilosc) 
        {
            $Produkt_id = (int)$Produkt_id;
            $Ilosc = max(1, (int)$Ilosc);

            $stmt = $connect->prepare("SELECT `Ilosc` FROM `pozycje_koszyka` pk JOIN `koszyki` k ON pk.Koszyk_id = k.Koszyk_id WHERE pk.Produkt_id = ? AND k.id_sesji = ?");
            $stmt->bind_param("is", $Produkt_id, $ID_sesji);
            $stmt->execute();
            $Stara_ilosc = $stmt->get_result();
            $Stara_ilosc = $Stara_ilosc->fetch_assoc();
            $Stara_ilosc = (int)$Stara_ilosc['Ilosc'];

            $Roznica = $Ilosc - $Stara_ilosc;

            $stmt = $connect->prepare("SELECT `Dostepnosc` FROM `produkty` WHERE `Produkt_id` = ?");
            $stmt->bind_param("i", $Produkt_id);
            $stmt->execute();
            $Dostepnosc = $stmt->get_result();
            $Dostepnosc = $Dostepnosc->fetch_assoc();
            $Dostepnosc = (int)$Dostepnosc['Dostepnosc'];

            if ($Roznica > 0 && $Roznica > $Dostepnosc) 
            {
                die("Brak wystarczającej dostępności produktu");
            }

            $stmt = $connect->prepare("UPDATE `produkty` SET `Dostepnosc` = `Dostepnosc` - ? WHERE `Produkt_id` = ?");
            $stmt->bind_param("ii", $Roznica, $Produkt_id);
            $stmt->execute();

            $stmt = $connect->prepare("UPDATE `pozycje_koszyka` pk JOIN `koszyki` k ON pk.Koszyk_id = k.Koszyk_id SET pk.Ilosc = ? WHERE pk.Produkt_id = ? AND k.id_sesji = ?");
            $stmt->bind_param("iis", $Ilosc, $Produkt_id, $ID_sesji);
            $stmt->execute();
        }
        header("Location: koszyk.php");
        exit;
    }

    $stmt = $connect->prepare("SELECT `Koszyk_id` FROM `koszyki` WHERE `id_sesji` = ?");
    $stmt->bind_param("s", $ID_sesji);
    $stmt->execute();
    $Koszyk_id = $stmt->get_result();

    if ($Koszyk_id->num_rows === 0) 
    {
        $stmt = $connect->prepare("INSERT INTO `koszyki` (id_sesji) VALUES (?)");
        $stmt->bind_param("s", $ID_sesji);
        $stmt->execute();
        $Koszyk_id = $connect->insert_id;
    } 
    else 
    {
        $Koszyk_id = $Koszyk_id->fetch_assoc();
        $Koszyk_id = (int)$Koszyk_id['Koszyk_id'];
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - koszyk</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/koszyk.css">
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
        <h2>Twój koszyk:</h2>
        <form method="post" action="koszyk.php">
            <table>
                <?php
                    echo "<tr>";
                        echo "<th>Numer porządkowy</th>";
                        echo "<th>Zdjęcie produktu</th>";
                        echo "<th>Nazwa produktu</th>";
                        echo "<th>Ilość</th>";
                        echo "<th>Cena (za sztukę)</th>";
                        echo "<th>Cena całkowita</th>";
                        echo "<th>Usuń</th>";
                    echo "</tr>";
                    $stmt = $connect->prepare("SELECT pk.*, p.Nazwa, p.Cena, z.Sciezka_do_zdjecia AS Zdjecie, k.Koszyk_id FROM koszyki k JOIN pozycje_koszyka pk ON k.Koszyk_id = pk.Koszyk_id JOIN produkty p ON pk.Produkt_id = p.Produkt_id LEFT JOIN zdjecia_produktow z ON z.Produkt_id = p.Produkt_id WHERE k.id_sesji = ?");
                    $stmt->bind_param("s", $ID_sesji);
                    $stmt->execute();
                    $Pozycje_koszyka = $stmt->get_result();

                    $Numer_porzadkowy = 1;
                    $Cena_calkowita = 0;

                    while ($Pozycja_koszyka = $Pozycje_koszyka->fetch_assoc()) 
                    {
                        $Calkowita = $Pozycja_koszyka['Cena'] * $Pozycja_koszyka['Ilosc'];
                        $Cena_calkowita =  $Cena_calkowita + $Calkowita;
                        $_SESSION['Cena_calkowita'] = $Cena_calkowita;

                        echo "<tr>";
                            echo "<td>$Numer_porzadkowy.</td>";
                            echo "<td><img src='../".htmlspecialchars($Pozycja_koszyka['Zdjecie'], ENT_QUOTES, 'UTF-8')."' alt='".htmlspecialchars($Pozycja_koszyka['Nazwa'], ENT_QUOTES, 'UTF-8')."' id='Zdjecie'></td>";
                            echo "<td>".htmlspecialchars($Pozycja_koszyka['Nazwa'], ENT_QUOTES, 'UTF-8')."</td>";
                            echo "<td><input type='number' name='Ilosc[".htmlspecialchars($Pozycja_koszyka['Produkt_id'], ENT_QUOTES, 'UTF-8')."]' value='".htmlspecialchars($Pozycja_koszyka['Ilosc'], ENT_QUOTES, 'UTF-8')."' min='1'></td>";
                            echo "<td>".htmlspecialchars($Pozycja_koszyka['Cena'], ENT_QUOTES, 'UTF-8')." zł</td>";
                            echo "<td>".htmlspecialchars($Calkowita, ENT_QUOTES, 'UTF-8')." zł</td>";
                            echo "<td>";
                                echo "<button type='submit' name='Usun' value='".htmlspecialchars($Pozycja_koszyka['Produkt_id'], ENT_QUOTES, 'UTF-8')."'>";
                                    echo "<img src='../Grafiki/Ikonki/Usuń.png' alt='Usuń'> Usuń";
                                echo "</button>";
                            echo "</td>";
                        echo "</tr>";
                        $Numer_porzadkowy++;
                    }
                ?>
            </table>
            <button type="submit" name="Przelicz">Przelicz ceny</button>
            <p>Łączna kwota to: <span id="Ostateczna_kwota"><?php echo $Cena_calkowita; ?> zł</span></p>
        </form>
        <button><a href="zamowienie.php">Zamówienie</a></button>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>