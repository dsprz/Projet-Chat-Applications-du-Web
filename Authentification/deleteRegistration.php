<?php
    include("Authentificateur.php");
    $login = $_POST["login"];
    $password = $_POST["password"];
    $confirmedPassword = $_POST["confirmedPassword"];
    $deleter = new Authentificateur($login, $password, $confirmedPassword);
    $deleter->deleteRegistration();
?>