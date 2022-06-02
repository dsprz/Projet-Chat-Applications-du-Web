<?php
    include("Authentificateur.php");
    $login = $_POST["login"];
    $password = $_POST["password"];
    $confirmedPassword = $_POST["confirmedPassword"];

    $auth = new Authentificateur($login, $password, $confirmedPassword);
    //echo("Le password est : ".$auth->getPassword());
    //echo("Le confirmed password est : ".$auth->getConfirmedPassword());
    $auth->addUser();
?>