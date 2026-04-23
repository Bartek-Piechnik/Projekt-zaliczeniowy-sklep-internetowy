<?php
    session_start();
    $_SESSION = [];
    session_destroy();
    header("Location: zaloguj_sie.php");
    exit;
?>