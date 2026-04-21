<?php
    require 'Config.php';
    session_start();
    $Bledy = [];

    if (!isset($_SESSION['Klient'])) 
    {
        header("Location: zaloguj_sie.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (empty($_POST['Ocena'])) 
        {
            $Bledy[] = "Nie podano oceny.";
        }
        if (empty($_POST['Komentarz'])) 
        {
            $Bledy[] = "Nie podano komentarza.";
        }

        if (empty($Bledy))
        {
            $Produkt_id = (int)$_POST['Produkt_id'];
            $Email = $_SESSION['Klient'];

            $stmt = $connect->prepare("SELECT `Klient_id` FROM `klienci` WHERE `E-mail` = ?");
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $Klient_id = $stmt->get_result();
            $Klient_id = $Klient_id->fetch_assoc();
            $Klient_id = (int)$Klient_id['Klient_id'];

            $Ocena = (int)$_POST['Ocena'];
            $Komentarz = $_POST['Komentarz'];
            
            $stmt = $connect->prepare("INSERT INTO `opinie` (`Produkt_id`, `Klient_id`, `Ocena`, `Komentarz`) VALUES (?, ?, ?, ?);");
            $stmt->bind_param("iiis", $Produkt_id, $Klient_id, $Ocena, $Komentarz);
            $stmt->execute();
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - opinia</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/opinia.css">
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
        <h2>Dodaj opinię: </h2>
        <form action="opinia.php" id="Formularz" method="post">
            <label for="Produkt_id">
                Nazwa produktu:
                <select name="Produkt_id" id="Produkt_id">
                    <?php
                        $Produkty = $connect->query("SELECT `Produkt_id`, `Nazwa` From `produkty`");
                        while ($Produkt = $Produkty->fetch_assoc())
                        {
                            echo "<option value='".$Produkt['Produkt_id']."'>".htmlspecialchars($Produkt['Nazwa'], ENT_QUOTES, 'UTF-8')."</option>";
                        }
                    ?>
                </select>
            </label>
            <label for="Ocena">
                Ocena: <input type="number" name="Ocena" id="Ocena" min="1" max="10">
            </label>
            <label for="Komentarz">
                Komentarz: <textarea name="Komentarz" id="Komentarz" maxlength="255"></textarea>
            </label>
            <button type="submit"><img src="../Grafiki/Ikonki/Dodaj.png" alt=""> Dodaj</button>
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