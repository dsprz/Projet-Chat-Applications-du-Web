<!DOCTYPE html>
<html lang="fr">
    <head>
    	<meta charset="utf-8">
		<title>S'identifier</title>
		<meta name="author" content="Jimmy VU">
		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<link rel="stylesheet" href="css/signup.css">
		<link rel="stylesheet" type="text/css" href="css/text.css">

    </head>
    <body>
        <h1> Connectez-vous </h1>

        <h2> Connexion </h2>
        <form action = "dosignin.php" method = "post">
            Nom d'utilisateur
            <input type = "text" name = "login">
            <br>
            Mot de passe
            <input type = "text" name = "password">
            <br><br>
            <input type = "submit" value = "Se connecter">
            <input type = "submit" formaction = "deleteForm.php" value = "Annuler">
            <input type = "submit" formaction = "signup.php" value = "S'inscrire">
        </form>
        <?php
            if(isset($_GET["badsignin"]))
            {
                echo("<br> Le mot de passe ou le nom d'utilisateur est incorrect </br>");
            }
        ?>
    </body>
</html> 
