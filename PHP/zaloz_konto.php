<?php
    require 'Config.php';
    session_start();
    $Bledy = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (empty($_POST['Imie'])) 
        {
            $Bledy[] = "Nie podano imienia.";
        }
        if (empty($_POST['Nazwisko'])) 
        {
            $Bledy[] = "Nie podano nazwiska.";
        }
        if (empty($_POST['E-mail'])) 
        {
            $Bledy[] = "Nie podano e-mail'a.";
        }
        if (empty($_POST['Telefon'])) 
        {
            $Bledy[] = "Nie podano telefonu.";
        }
        if (empty($_POST['Haslo'])) 
        {
            $Bledy[] = "Nie podano hasła.";
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

        if (empty($Bledy))
        {
            $Imie = $_POST['Imie'];
            $Nazwisko = $_POST['Nazwisko'];
            $Email = $_POST['E-mail'];
            $Telefon = $_POST['Telefon'];
            $Haslo = password_hash($_POST['Haslo'], PASSWORD_DEFAULT);
            $Miasto = $_POST['Miasto'];
            $Ulica = $_POST['Ulica'];
            $Numer_domu_mieszkania = $_POST['Numer_domu_mieszkania'];
            $Kod_pocztowy = $_POST['Kod_pocztowy'];
            $Wojewodztwo_id = (int)$_POST['Wojewodztwo_id'];
            $Czy_admin = 0;

            $stmt = $connect->prepare("SELECT `Klient_id` FROM `klienci` WHERE `E-mail` = ?");
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $Klient_id = $stmt->get_result();

            if ($Klient_id->num_rows > 0) 
            {
                $Bledy[] = "Konto z tym e-mailem już istnieje.";
            }

            if (empty($Bledy))
            {
                $stmt = $connect->prepare("INSERT INTO `adresy` (`Miasto`, `Ulica`, `Numer_domu_mieszkania`, `Kod_pocztowy`, `Wojewodztwo_id`) VALUES (?, ?, ?, ?, ?);");
                $stmt->bind_param("ssssi", $Miasto, $Ulica, $Numer_domu_mieszkania, $Kod_pocztowy, $Wojewodztwo_id);
                $stmt->execute();
                $Adres_id = $connect->insert_id;
                
                $stmt = $connect->prepare("INSERT INTO `klienci` (`Imie`, `Nazwisko`, `E-mail`, `Telefon`, `Haslo`, `Adres_id`, `Czy_admin`) VALUES (?, ?, ?, ?, ?, ?, ?);");
                $stmt->bind_param("sssssii", $Imie, $Nazwisko, $Email, $Telefon, $Haslo, $Adres_id, $Czy_admin);
                $stmt->execute();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - zaloz konto</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/zaloz_konto.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amarante&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <img src="../Grafiki/Baner.png" alt="Baner o treści: Piechnikovsky STORE" id="Zdjecie_banera">
        <nav id="Nawigacja">
            <ul id="Lista">
                <li id="Element_listy"><a href="konto.php"><img src="../Grafiki/Ikonki/Konto.png" alt=""> Konto</a></li>
            </ul>
        </nav>
    </header>
    <main id="Strona_glowna">
        <h2>Stwórz konto:</h2>
        <?php 
            if (!empty($Bledy)) 
            {
                foreach ($Bledy as $Blad) 
                {
                    echo "<p style='color:red;'>$Blad</p>";
                }
            }
        ?>
        <form action="zaloz_konto.php" id="Formularz" method="post">
            <label for="Imie">
                Imię: <input type="text" name="Imie" id="Imie" maxlength="50">
            </label>
            <label for="Nazwisko">
                Nazwisko: <input type="text" name="Nazwisko" id="Nazwisko" maxlength="50">
            </label>
            <label for="E-mail">
                E-mail: <input type="email" name="E-mail" id="E-mail" maxlength="100">
            </label>
            <label for="Telefon">
                Telefon: <input type="tel" name="Telefon" id="Telefon" maxlength="20">
            </label>
            <label for="Haslo">
                Hasło: <input type="password" name="Haslo" id="Haslo" maxlength="255">
            </label>
            <label for="Miasto">
                Miasto: <input type="text" name="Miasto" id="Miasto" maxlength="100">
            </label>
            <label for="Ulica">
                Ulica: <input type="text" name="Ulica" id="Ulica" maxlength="100">
            </label>
            <label for="Numer_domu_mieszkania">
                Numer domu/mieszkania: <input type="text" name="Numer_domu_mieszkania" id="Numer_domu_mieszkania" maxlength="10">
            </label>
            <label for="Kod_pocztowy">
                Kod pocztowy: <input type="text" name="Kod_pocztowy" id="Kod_pocztowy" maxlength="6">
            </label>
            <label for="Wojewodztwo_id">
                    Województwo:
                    <select name="Wojewodztwo_id" id="Wojewodztwo_id">
                        <?php
                            $Wojewodztwa = $connect->query("SELECT * From `wojewodztwa`");
                            while ($Wojewodztwo = $Wojewodztwa->fetch_assoc())
                            {
                                echo "<option value='".htmlspecialchars($Wojewodztwo['Wojewodztwo_id'], ENT_QUOTES, 'UTF-8')."'>".htmlspecialchars($Wojewodztwo['Nazwa'], ENT_QUOTES, 'UTF-8')."</option>";
                            }
                        ?> 
                    </select>
            </label>
            <button type="submit"><img src="../Grafiki/Ikonki/Zaloguj.png" alt=""> Zapisz</button>
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