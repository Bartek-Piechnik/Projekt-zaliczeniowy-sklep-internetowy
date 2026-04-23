<?php 
    require 'Config.php';
    session_start();
    $ID_sesji = session_id();
    
    if (!isset($_SESSION['Klient'])) 
    {
        header("Location: zaloguj_sie.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $Produkt_id = (int)$_POST['Produkt_id'];
        $Ilosc_sztuk = (int)$_POST['Ilosc_sztuk'];

        if ($Ilosc_sztuk < 1) 
        {
            $Ilosc_sztuk = 1;
        }

        $stmt = $connect->prepare("SELECT `Dostepnosc` FROM `produkty` WHERE `Produkt_id` = ?");
        $stmt->bind_param("i", $Produkt_id);
        $stmt->execute();
        $Dostepnosc = $stmt->get_result();

        if ($Dostepnosc->num_rows === 0) 
        {
            die("Produkt nie jest aktualnie dostępny");
        }

        $Dostepnosc = $Dostepnosc->fetch_assoc();
        if ($Ilosc_sztuk > $Dostepnosc['Dostepnosc']) 
        {
            $Ilosc_sztuk = (int)$Dostepnosc['Dostepnosc'];
        }

        $stmt = $connect->prepare("SELECT `Koszyk_id` FROM `koszyki` WHERE `id_sesji` = ?");
        $stmt->bind_param("s", $ID_sesji);
        $stmt->execute();
        $Koszyk_id = $stmt->get_result();
        $Koszyk_id = $Koszyk_id->fetch_assoc();

        if (!$Koszyk_id) 
        {
            $stmt = $connect->prepare("INSERT INTO `koszyki` (id_sesji) VALUES (?)");
            $stmt->bind_param("s", $ID_sesji);
            $stmt->execute();
            $Koszyk_id = $connect->insert_id;
        } 
        else 
        {
            $Koszyk_id = (int)$Koszyk_id['Koszyk_id'];
        }

        $stmt = $connect->prepare("SELECT `Dostepnosc` FROM `produkty` WHERE `Produkt_id` = ?");
        $stmt->bind_param("i", $Produkt_id);
        $stmt->execute();
        $Dostepnosc = $stmt->get_result();
        $Dostepnosc = $Dostepnosc->fetch_assoc();
        $Dostepnosc = (int)$Dostepnosc['Dostepnosc'];
        
        if ($Ilosc_sztuk > $Dostepnosc || $Dostepnosc <= 0) 
        {
            die("Brak wystarczającej dostępności produktu");
        }

        $stmt = $connect->prepare("UPDATE `produkty` SET `Dostepnosc` = `Dostepnosc` - ? WHERE `Produkt_id` = ? AND `Dostepnosc` >= ?");
        $stmt->bind_param("iii", $Ilosc_sztuk, $Produkt_id, $Ilosc_sztuk);
        $stmt->execute();

        $stmt = $connect->prepare("SELECT `Ilosc` FROM `pozycje_koszyka` WHERE `Koszyk_id` = ? AND `Produkt_id` = ?");
        $stmt->bind_param("ii", $Koszyk_id, $Produkt_id);
        $stmt->execute();
        $Ilosc = $stmt->get_result();

        if ($Ilosc->num_rows > 0) 
        {
            $Ilosc = $Ilosc->fetch_assoc();
            $Nowa_ilosc = (int)$Ilosc['Ilosc'] + $Ilosc_sztuk;
            $stmt = $connect->prepare("UPDATE `pozycje_koszyka` SET `Ilosc` = ? WHERE `Koszyk_id` = ? AND `Produkt_id` = ?");
            $stmt->bind_param("iii", $Nowa_ilosc, $Koszyk_id, $Produkt_id);
            $stmt->execute();
        } 
        else 
        {
            $stmt = $connect->prepare("INSERT INTO `pozycje_koszyka` (Koszyk_id, Produkt_id, Ilosc) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $Koszyk_id, $Produkt_id, $Ilosc_sztuk);
            $stmt->execute();
        }

        header("Location: koszyk.php");
        exit;
    }
    $connect->close();
?>