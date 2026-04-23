<?php
    require '../Config.php';
    session_start();
    $Bledy = [];
    
    if (!isset($_SESSION['Czy_admin']) || $_SESSION['Czy_admin'] != 1) 
    {
        header("Location: ../zaloguj_sie.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (empty($_POST['Produkt_id'])) 
        {
            $Bledy[] = "Nie podano Id produktu.";
        }
        if (empty($_POST['Nazwa_produktu'])) 
        {
            $Bledy[] = "Nie podano nazwy produktu.";
        }
        if (empty($_POST['Opis_produktu'])) 
        {
            $Bledy[] = "Nie podano opisu produktu.";
        }
        if (empty($_POST['Cena_produktu'])) 
        {
            $Bledy[] = "Nie podano ceny produktu.";
        }
        if (empty($_POST['Stan_magazynowy_produktu'])) 
        {
            $Bledy[] = "Nie podano stanu magazynowego produktu.";
        }
        if (empty($_POST['Dostepnosc_produktu'])) 
        {
            $Bledy[] = "Nie podano dostępności produktu.";
        }

        if (empty($Bledy))
        {
            $Produkt_id = (int)$_POST['Produkt_id'];
            $Nazwa_produktu = $_POST['Nazwa_produktu'];
            $Opis_produktu = $_POST['Opis_produktu'];
            $Cena_produktu = $_POST['Cena_produktu'];
            $Stan_magazynowy_produktu = (int)$_POST['Stan_magazynowy_produktu'];
            $Dostepnosc_produktu = (int)$_POST['Dostepnosc_produktu'];
            $Kategoria_id = (int)$_POST['Kategoria_id'];

            $stmt = $connect->prepare("UPDATE `produkty` SET `Kategoria_id` = ?, `Nazwa` = ?, `Opis` = ?, `Cena` = ?, `Stan_magazynowy` = ?, `Dostepnosc` = ? WHERE `Produkt_id` = ?;");
            $stmt->bind_param("issdiii", $Kategoria_id, $Nazwa_produktu, $Opis_produktu, $Cena_produktu, $Stan_magazynowy_produktu, $Dostepnosc_produktu, $Produkt_id);
            $stmt->execute();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - ADMIN modyfikuj produkty</title>
    <link rel="icon" type="image/x-icon" href="../../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../../CSS/Admin/glowny.css">
    <link rel="stylesheet" href="../../CSS/Admin/wspolne_formularze.css">
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
        <h2>Modyfikuj produkty:</h2>
        <?php 
            if (!empty($Bledy)) 
            { 
                foreach ($Bledy as $Blad) 
                { 
                    echo "<p style='color:red;'>".htmlspecialchars($Blad, ENT_QUOTES, 'UTF-8')."</p>"; 
                } 
            }
        ?>
        <form action="modyfikuj_produkty.php" id="Formularz" method="post">
            <label for="Produkt_id">
                Id produktu: <input type="number" name="Produkt_id" id="Produkt_id">
            </label>
            <label for="Nazwa_produktu">
                Nazwa produktu: <input type="text" name="Nazwa_produktu" id="Nazwa_produktu" maxlength="150">
            </label>
            <label for="Opis_produktu">
                Opis produktu: <textarea name="Opis_produktu" id="Opis_produktu"></textarea>
            </label>
            <label for="Cena_produktu">
                Cena produktu: <input type="number" name="Cena_produktu" id="Cena_produktu" maxlength="12">
            </label>
            <label for="Stan_magazynowy_produktu">
                Stan magazynowy produktu: <input type="number" name="Stan_magazynowy_produktu" id="Stan_magazynowy_produktu" maxlength="5">
            </label>
            <label for="Dostepnosc_produktu">
                Dostępność produktu: <input type="number" name="Dostepnosc_produktu" id="Dostepnosc_produktu" maxlength="4">
            </label>
            <label for="Kategoria_id">
                Kategoria produktu:
                <select name="Kategoria_id" id="Kategoria_id">
                    <?php
                        $Kategorie = $connect->query("SELECT `Kategoria_id`, `Nazwa` From `kategorie`");
                        while ($Kategoria = $Kategorie->fetch_assoc())
                        {
                            echo "<option value='".htmlspecialchars($Kategoria['Kategoria_id'], ENT_QUOTES, 'UTF-8')."'>".htmlspecialchars($Kategoria['Nazwa'], ENT_QUOTES, 'UTF-8')."</option>";
                        }
                    ?>
                </select>
            </label>
            <button type="submit">Modyfikuj</button>
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