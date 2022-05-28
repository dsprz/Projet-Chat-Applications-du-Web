<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Sign in</title>
        <meta name ="author" content = "Jimmy VU">
        <link rel = "stylesheet" href="css/signup.css">
        <link rel = "stylesheet" type = "text" href="css/text.css">
    </head>
    <body>
        <h1> Authentification </h1>
        <hr>

        <form action = "addUser.php" method = "post">
            <br>
            Username
            <input type = "text" name = "login">
            <br>
            Mot de passe
            <input type = "text" name = "password">
            <br>
            Confirmez votre mot de passe
            <br>
            <input type = "text" name = "confirmedPassword">
            <br><br>
            <input type = "submit" value = "S'inscrire">
            <input type = "submit" value = "Annuler">
        </form>
        <?php
        if(isset($_GET["badsignup"]))
        {
            $bs = $_GET["badsignup"];
            switch($bs)
            {
                case 1:
                    echo("<br>Le nom d'utilisateur ne doit contenir que des caractères alphanumériques</br>");
                case 2:
                    echo("<br>Le nom d'utilisateur est déjà pris</br>");
                case 3:
                    echo("<br>Le mot de passe est trop court</br>");
                case 4:
                    echo("<br>Les mots de passe de correspondent pas</br>");
            }
        }
        ?>
    </body>
</html>

