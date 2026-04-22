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
    <title>Piechnikovsky STORE - kategorie</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/kategorie.css">
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
        <h2>Lista kategorii:</h2>
        <section id="Kategorie">
            <?php
                $Kategorie = $connect->query("SELECT * From `kategorie`");
                while ($Kategoria = $Kategorie->fetch_assoc())
                {
                    echo "<section id='Kategoria'>";
                        echo "<a href='../PHP/produkty.php?id=".(int)$Kategoria['Kategoria_id']."' id='Link'>";
                            echo"<img src='../".htmlspecialchars($Kategoria['Zdjecie'], ENT_QUOTES, 'UTF-8')."' alt='".htmlspecialchars($Kategoria['Nazwa'], ENT_QUOTES, 'UTF-8')."'>";
                            echo "<h3 id='Nazwa_kategorii'>".htmlspecialchars($Kategoria['Nazwa'], ENT_QUOTES, 'UTF-8')."</h3>";
                            echo "<h3 id='Opis_kategorii'>".htmlspecialchars($Kategoria['Opis'], ENT_QUOTES, 'UTF-8')."</h3>";
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