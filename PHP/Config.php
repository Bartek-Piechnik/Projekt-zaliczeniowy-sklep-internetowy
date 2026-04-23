<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "3tpa_2025_-_projekt_zaliczeniowy_(sklep_internetowy)";

    $connect = new mysqli($host, $user, $password, $database);
    
    if ($connect->connect_error) 
    {
        echo "Błąd".$connect->connect_error;
        echo "Kod błędu:".$connect->connect_errno;
    }
?>