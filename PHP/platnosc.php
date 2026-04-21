<?php 
    require 'Config.php';
    session_start();
    
    if (!isset($_SESSION['Klient'])) 
    {
        header("Location: zaloguj_sie.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if (!isset($_POST['Metoda_platnosci_id'])) 
        {
            header("Location: platnosc.php");
            exit;
        }

        $Metoda_platnosci_id = (int)$_POST['Metoda_platnosci_id'];
        $_SESSION['Metoda_platnosci_id'] = $Metoda_platnosci_id;

        switch ($Metoda_platnosci_id) 
        {
            case 1:
                header("Location: Metody płatności/blik.php");
                break;
            case 2:
                header("Location: Metody płatności/paypal.php");
                break;
            case 3: 
                header("Location: zakonczenie_platnosci.php");
                break;
            default:
                header("Location: platnosc.php");
                exit;
        }
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - płatność</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/platnosc.css">
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
        <h2>4. Płatność:</h2>
        <form action="platnosc.php" id="Sposob_platnosci_form" method="post">
            <?php
                $Metody_platnosci = $connect->query("SELECT * FROM `metody_platnosci`");
                while ($Metoda_platnosci = $Metody_platnosci->fetch_assoc()) 
                {
                    echo "<label id='Przycisk'>";
                        echo "<input type='radio' name='Metoda_platnosci_id' value='".(int)$Metoda_platnosci['Metoda_platnosci_id']."' required>";
                        echo "<span id='Zdjecie'>";
                            echo "<img src='../".htmlspecialchars($Metoda_platnosci['Zdjecie'], ENT_QUOTES, 'UTF-8')."' alt='".htmlspecialchars($Metoda_platnosci['Nazwa'], ENT_QUOTES, 'UTF-8')."'>";
                            echo "<h1 id='Nazwa'>".htmlspecialchars($Metoda_platnosci['Nazwa'], ENT_QUOTES, 'UTF-8')."</h1>";
                            echo "<p id='Opis'>".htmlspecialchars($Metoda_platnosci['Opis'], ENT_QUOTES, 'UTF-8')."</p>";
                        echo "</span>";
                    echo "</label>";
                }
            ?>
            <button type="submit"><img src="../Grafiki/Ikonki/Zapłać.png" alt="">Zapłać</button>
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