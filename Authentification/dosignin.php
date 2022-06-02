<?php
    session_start();
    include("Authentificateur.php");
    $login = $_POST["login"];
    $password = $_POST["password"];
    $check = new Authentificateur($login, $password);
    $check->signIn();
?>