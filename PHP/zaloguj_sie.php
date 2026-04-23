<?php
    require 'Config.php';
    session_start();
    $Bledy = [];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (empty($_POST['E-mail'])) 
        {
            $Bledy[] = "Nie podano e-mail`a.";
        }
        if (empty($_POST['Haslo'])) 
        {
            $Bledy[] = "Nie podano hasła.";
        }

        if (empty($Bledy))
        {
            $Email = $_POST['E-mail'];
            $Haslo = $_POST['Haslo'];

            $stmt = $connect->prepare("SELECT `Haslo`, `Czy_admin`, `E-mail` FROM `klienci` WHERE `E-mail` = ?");
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $Klient = $stmt->get_result();

            if ($Klient->num_rows === 1) 
            {
                $Klient = $Klient->fetch_assoc();

                if (password_verify($Haslo, $Klient['Haslo'])) 
                {
                    $_SESSION['Czy_admin'] = $Klient['Czy_admin'];
                    $_SESSION['Klient'] = $Klient['E-mail'];

                    if ($Klient['Czy_admin'] == 1) 
                    {
                        header("Location: Admin/index.php");
                    } 
                    else 
                    {
                        header("Location: index.php");
                    }
                    exit;
                }
                else 
                {
                    $Bledy[] = "Błędne hasło!";
                }
            } 
            else 
            {
                $Bledy[] = "Nie ma takiego użytkownika!";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piechnikovsky STORE - zaloguj się</title>
    <link rel="icon" type="image/x-icon" href="../Grafiki/Favicon.png">
    <link rel="stylesheet" href="../CSS/glowny.css">
    <link rel="stylesheet" href="../CSS/zaloguj_sie.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amarante&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <img src="../Grafiki/Baner.png" alt="Baner o treści: Piechnikovsky STORE" id="Zdjecie_banera">
        <nav id="Nawigacja">
            <h1>Strona logowania</h1>
        </nav>
    </header>
    <main id="Strona_glowna">
        <h2>Zaloguj się do swojego konta:</h2>
        <?php 
            if (!empty($Bledy)) 
            { 
                foreach ($Bledy as $Blad) 
                { 
                    echo "<p style='color:red;'>".htmlspecialchars($Blad, ENT_QUOTES, 'UTF-8')."</p>"; 
                } 
            }
        ?>
        <form action="zaloguj_sie.php" id="Formularz" method="post">
            <label for="E-mail">
                E-mail: <input type="email" name="E-mail" id="E-mail" maxlength="100">
            </label>
            <label for="Haslo">
                Hasło: <input type="password" name="Haslo" id="Haslo" maxlength="255">
            </label>
            <button type="submit"><img src="../Grafiki/Ikonki/Zaloguj.png" alt=""> Zaloguj się</button>
            <hr>
            <a href="zaloz_konto.php">Nie masz konta? Załóż je tutaj</a>
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