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
    <title>Piechnikovsky STORE - produkty</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/produkty.css">
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
        <h2>Lista produktów:</h2>
        <section id="Produkty">
            <?php
                $Kategoria_id = (int)$_GET['id'];

                $stmt = $connect->prepare("SELECT p.Produkt_id, p.Nazwa, p.Cena, z.Sciezka_do_zdjecia From `produkty` p Join `zdjecia_produktow` z ON z.Produkt_id = p.Produkt_id WHERE `Kategoria_id` = ?");
                $stmt->bind_param("i", $Kategoria_id);
                $stmt->execute();
                $Produkty = $stmt->get_result();
                
                while ($Produkt = $Produkty->fetch_assoc())
                {
                    echo "<section id='Produkt'>";
                        echo "<a href='../PHP/produkt.php?id=".htmlspecialchars($Produkt['Produkt_id'], ENT_QUOTES, 'UTF-8')."' id='Link'>";
                            echo "<img src='../".htmlspecialchars($Produkt['Sciezka_do_zdjecia'], ENT_QUOTES, 'UTF-8')."' alt='".htmlspecialchars($Produkt['Nazwa'], ENT_QUOTES, 'UTF-8')."'>";
                            echo "<h3 id='Nazwa_produktu'>".htmlspecialchars($Produkt['Nazwa'], ENT_QUOTES, 'UTF-8')."</h3>";
                            echo "<h3 id='Cena_produktu'>".htmlspecialchars($Produkt['Cena'], ENT_QUOTES, 'UTF-8')." zł</h3>";
                        echo "</a>";
                    echo "</section>";
                }
            ?> 
        </section>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>