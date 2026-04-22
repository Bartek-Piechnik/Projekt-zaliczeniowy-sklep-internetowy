<?php 
    require 'Config.php';
    session_start();
    $Bledy = [];
    
    if (!isset($_SESSION['Klient'])) 
    {
        header("Location: zaloguj_sie.php");
        exit;
    }

    $Email= $_SESSION['Klient'];

    $stmt = $connect->prepare("SELECT * FROM `klienci` k Join `adresy` a ON k.Adres_id = a.Adres_id WHERE `E-mail` = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $Konto = $stmt->get_result();
    $Konto = $Konto->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if (empty($_POST['Imie'])) 
        {
            $Bledy[] = "Nie podano imienia.";
        }
        if (empty($_POST['Nazwisko'])) 
        {
            $Bledy[] = "Nie podano nazwiska.";
        }
        if (empty($_POST['Telefon'])) 
        {
            $Bledy[] = "Nie podano telefonu.";
        }
        if (empty($_POST['E-mail'])) 
        {
            $Bledy[] = "Nie podano e-mail'a.";
        }
        if (empty($_POST['Miasto'])) 
        {
            $Bledy[] = "Nie podano miasta.";
        }
        if (empty($_POST['Ulica'])) 
        {
            $Bledy[] = "Nie podano ulicy.";
        }
        if (empty($_POST['Numer_domu_mieszkania'])) 
        {
            $Bledy[] = "Nie podano numeru domu/mieszkania.";
        }
        if (empty($_POST['Kod_pocztowy'])) 
        {
            $Bledy[] = "Nie podano kodu pocztowego.";
        }
        if (empty($_POST['Metody_wysylki_id'])) 
        {
            $Bledy[] = "Nie wybrano sposobu wysyłki.";
        } 

        if (empty($Bledy))
        {
            $Imie = $_POST['Imie'];
            $Nazwisko = $_POST['Nazwisko'];
            $Telefon = $_POST['Telefon'];
            $E_mail = $_POST['E-mail'];
            $Miasto = $_POST['Miasto'];
            $Ulica = $_POST['Ulica'];
            $Numer_domu_mieszkania = $_POST['Numer_domu_mieszkania'];
            $Kod_pocztowy = $_POST['Kod_pocztowy'];
            $Wojewodztwo_id = (int)$_POST['Wojewodztwo_id'];
            $Adres_id = (int)$Konto['Adres_id'];
            $Metoda_wysylki_id = (int)$_POST['Metody_wysylki_id'];

            $Klient_id = (int)$Konto['Klient_id'];

            $stmt = $connect->prepare("UPDATE `klienci` SET `Imie` = ?, `Nazwisko` = ?, `E-mail` = ?, `Telefon` = ? WHERE `Klient_id` = ?");
            $stmt->bind_param("ssssi", $Imie, $Nazwisko, $E_mail, $Telefon, $Klient_id);
            $stmt->execute();
            $_SESSION['Klient'] = $E_mail;

            $Adres_id = (int)$Konto['Adres_id'];
                    
            $stmt = $connect->prepare("UPDATE `adresy` SET `Miasto` = ?, `Ulica` = ?, `Numer_domu_mieszkania` = ?, `Kod_pocztowy` = ?, `Wojewodztwo_id` = ? WHERE `Adres_id` = ?");
            $stmt->bind_param("ssssii", $Miasto, $Ulica, $Numer_domu_mieszkania, $Kod_pocztowy, $Wojewodztwo_id, $Adres_id);
            $stmt->execute();

            $Metody_wysylki_id = (int)$_POST['Metody_wysylki_id'];
            $_SESSION['Metody_wysylki_id'] = $Metody_wysylki_id;

            header("Location: platnosc.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - zamówienie</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/zamowienie.css">
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
        <h2>Zamówienie:</h2>
        <?php 
            if (!empty($Bledy)) 
            { 
                foreach ($Bledy as $Blad) 
                { 
                    echo "<p style='color:red;'>".htmlspecialchars($Blad, ENT_QUOTES, 'UTF-8')."</p>"; 
                } 
            }
        ?>
        <form action="zamowienie.php" id="Dane_osobowe_form" method="post">
            <section id="Dane_osobowe">
                <h1>1. Dane osobowe</h1>
                <label for="Imie">
                    Imię: <input type="text" name="Imie" id="Imie" maxlength="50" value="<?php echo htmlspecialchars($Konto['Imie'], ENT_QUOTES, 'UTF-8')?>">
                </label>
                <label for="Nazwisko">
                    Nazwisko: <input type="text" name="Nazwisko" id="Nazwisko" maxlength="50" value="<?php echo htmlspecialchars($Konto['Nazwisko'], ENT_QUOTES, 'UTF-8')?>">
                </label>
                <label for="Telefon">
                    Telefon: <input type="tel" name="Telefon" id="Telefon" maxlength="20" value="<?php echo htmlspecialchars($Konto['Telefon'], ENT_QUOTES, 'UTF-8')?>">
                </label>
                <label for="E-mail">
                    E-mail: <input type="email" name="E-mail" id="E-mail" maxlength="100" value="<?php echo htmlspecialchars($Konto['E-mail'], ENT_QUOTES, 'UTF-8')?>">
                </label>
            </section>
            <section id="Adres">
                <h1>2. Adres</h1>
                <label for="Miasto">
                    Miasto: <input type="text" name="Miasto" id="Miasto" value="<?php echo htmlspecialchars($Konto['Miasto'], ENT_QUOTES, 'UTF-8')?>">
                </label>
                <label for="Ulica">
                    Ulica: <input type="text" name="Ulica" id="Ulica" value="<?php echo htmlspecialchars($Konto['Ulica'], ENT_QUOTES, 'UTF-8')?>">
                </label>
                <label for="Numer_domu_mieszkania">
                    Numer domu/mieszkania: <input type="text" name="Numer_domu_mieszkania" id="Numer_domu_mieszkania" value="<?php echo htmlspecialchars($Konto['Numer_domu_mieszkania'], ENT_QUOTES, 'UTF-8')?>">
                </label>
                <label for="Kod_pocztowy">
                    Kod pocztowy: <input type="text" name="Kod_pocztowy" id="Kod_pocztowy" value="<?php echo htmlspecialchars($Konto['Kod_pocztowy'], ENT_QUOTES, 'UTF-8')?>">
                </label>
                <label for="Wojewodztwo_id">
                    Województwo:
                    <select name="Wojewodztwo_id" id="Wojewodztwo_id">
                        <?php
                            $Wojewodztwa = $connect->query("SELECT * From `wojewodztwa`");
                            while ($Wojewodztwo = $Wojewodztwa->fetch_assoc())
                            {
                                if ($Wojewodztwo['Wojewodztwo_id'] === $Konto['Wojewodztwo_id'])
                                {
                                    echo "<option value='".htmlspecialchars($Wojewodztwo['Wojewodztwo_id'], ENT_QUOTES, 'UTF-8')."' selected>".htmlspecialchars($Wojewodztwo['Nazwa'], ENT_QUOTES, 'UTF-8')."</option>";
                                }
                                else
                                {
                                    echo "<option value='".htmlspecialchars($Wojewodztwo['Wojewodztwo_id'], ENT_QUOTES, 'UTF-8')."'>".htmlspecialchars($Wojewodztwo['Nazwa'], ENT_QUOTES, 'UTF-8')."</option>";
                                }
                            }
                        ?> 
                    </select>
                </label>
            </section>
            <section id="Metody_wysylki_id">
                <h1>3. Sposób wysyłki</h1>
                <?php
                    $Metody_wysylki = $connect->query("SELECT mw.*, kdd.* FROM `metody_wysylki` mw JOIN `kwoty_darmowej_dostawy` kdd ON mw.Kwota_darmowej_dostawy_id = kdd.Kwota_darmowej_dostawy_id");
                    while ($Metoda_wysylki = $Metody_wysylki->fetch_assoc()) 
                    {
                        echo "<label id='Przycisk'>";
                            echo "<input type='radio' name='Metody_wysylki_id' value='".htmlspecialchars($Metoda_wysylki['Metoda_wysylki_id'], ENT_QUOTES, 'UTF-8')."' required>";
                            echo "<span id='Zdjecie'>";
                                echo "<img src='../".htmlspecialchars($Metoda_wysylki['Zdjecie'], ENT_QUOTES, 'UTF-8')."' alt='".htmlspecialchars($Metoda_wysylki['Nazwa'], ENT_QUOTES, 'UTF-8')."'>";
                                echo "<h1 id='Nazwa'>".htmlspecialchars($Metoda_wysylki['Nazwa'], ENT_QUOTES, 'UTF-8')."</h1>";
                                echo "<p id='Opis'>".htmlspecialchars($Metoda_wysylki['Opis'], ENT_QUOTES, 'UTF-8')."</p>";
                                echo "<p id='Koszt'>Koszt: ".htmlspecialchars($Metoda_wysylki['Koszt'], ENT_QUOTES, 'UTF-8')." zł</p>";
                                echo "<p id='Darmowa_od'>Darmowa od: ".htmlspecialchars($Metoda_wysylki['Kwota'], ENT_QUOTES, 'UTF-8')." zł</p>";
                            echo "</span>";
                        echo "</label>";
                    }
                ?>
            </section>
            <button type="submit">Płatność</button>
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