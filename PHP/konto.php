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
    <title>Piechnikovsky STORE - konto</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/konto.css">
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
        <h2>Konto:</h2>
        <section id="Konto">
            <?php
                $Email= $_SESSION['Klient'];
                $stmt = $connect->prepare("SELECT * FROM `klienci` k JOIN `adresy` a ON k.Adres_id = a.Adres_id JOIN `wojewodztwa` w ON a.Wojewodztwo_id = w.Wojewodztwo_id WHERE `E-mail` = ?");
                $stmt->bind_param("s", $Email);
                $stmt->execute();
                $Konto = $stmt->get_result();
                
                if ($Konto && $Konto->num_rows === 1) 
                {
                    $Konto = $Konto->fetch_assoc();
                    echo "<section id='Konto_karta'>";
                        echo "<section id='Zdjecie'>";
                            echo "<img src='../Grafiki/Ikonki/Profilowe.png' alt='Profilowe'>";
                        echo "</section>";
                        echo "<h3>Imię: ".htmlspecialchars($Konto['Imie'], ENT_QUOTES, 'UTF-8')."</h3>";
                        echo "<h3>Nazwisko: ".htmlspecialchars($Konto['Nazwisko'], ENT_QUOTES, 'UTF-8')."</h3>";
                        echo "<h3>E-mail: ".htmlspecialchars($Konto['E-mail'], ENT_QUOTES, 'UTF-8')."</h3>";
                        echo "<h3>Telefon: ".htmlspecialchars($Konto['Telefon'], ENT_QUOTES, 'UTF-8')."</h3>";
                        echo "<h3>Miasto: ".htmlspecialchars($Konto['Miasto'], ENT_QUOTES, 'UTF-8')."</h3>";
                        echo "<h3>Ulica: ".htmlspecialchars($Konto['Ulica'], ENT_QUOTES, 'UTF-8')."</h3>";
                        echo "<h3>Numer domu/mieszkania: ".htmlspecialchars($Konto['Numer_domu_mieszkania'], ENT_QUOTES, 'UTF-8')."</h3>";
                        echo "<h3>Kod pocztowy: ".htmlspecialchars($Konto['Kod_pocztowy'], ENT_QUOTES, 'UTF-8')."</h3>";
                        echo "<h3>Województwo: ".htmlspecialchars($Konto['Nazwa'], ENT_QUOTES, 'UTF-8')."</h3>";
                    echo "</section>";
                }
                else 
                {
                    echo "<p>Nie znaleziono danych konta.</p>";
                }
            ?> 
        </section>
        <a href="wyloguj.php" id="Wyloguj"><img src="../Grafiki/Ikonki/Zaloguj.png" alt=""> Wyloguj się</a>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>