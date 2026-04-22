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
    <title>Piechnikovsky STORE - index</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/index.css">
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
            $Email = $_SESSION['Klient'];
            $stmt = $connect->prepare("SELECT `Imie` FROM `klienci` WHERE `E-mail` = ?");
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $Imie = $stmt->get_result();
            $Imie = $Imie->fetch_assoc();
            $Imie = $Imie['Imie'];
        ?>
        <h1>Witaj <?php echo htmlspecialchars($Imie, ENT_QUOTES, 'UTF-8'); ?> w Piechnikovsky STORE!</h1>
        <p>Odkryj wyjątkową kolekcję produktów, które łączą jakość, styl i pasję.</p>
        <p>Każdy przedmiot w naszym sklepie został starannie wybrany, by sprostać oczekiwaniom nawet najbardziej wymagających klientów.</p>
        <p>Kupuj z klasą. Wybieraj Piechnikovsky.</p>
    </main>
    <footer id="Stopka">
        <p>Projekt zaliczeniowy (sklep internetowy) Bartek Piechnik 3Tpa</p>
    </footer>
    <?php
        $connect->close();
    ?>
</body>
</html>