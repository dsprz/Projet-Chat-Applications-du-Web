<!DOCTYPE html>
<html lang ="fr">
    <head>
        <meta charset="utf-8">
        <title>Sign in</title>
        <meta name ="author" content = "Jimmy VU">
        <link rel = "stylesheet" href="css/signup.css">
        <link rel = "stylesheet" type = "text" href="css/text.css">
    </head>
    <body>
        <h1> Se désinscrire </h1>
        <hr>

        <form action = "deleteRegistration.php" method = "post">
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
            <input type = "submit" value = "Se désinscrire">
        </form>
    <?php
        if(isset($_GET["badlogin"]))
        {
            $bl = $_GET["badlogin"];
            switch($bl)
            {
                case 1:
                    echo("<br>Cet utilisateur n'est pas enregistré.</br>");
                case 2:
                    echo("<br>Les mots de passe ne correspondent pas.</br>");
            }
        }
    ?>
    </body>
</html>
