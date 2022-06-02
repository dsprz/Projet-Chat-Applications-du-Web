<!DOCTYPE html>
    <?php
        session_start();
        $login = $_SESSION["login"];
    ?>
    <script type = "text/javascript">
        var session  = "<?php echo $login;?>";
    </script>
    <html lang="fr">
        <head>
        <meta charset="utf-8">
        <title>Chat room</title>
        <meta name ="author" content = "Jimmy VU">
        <link rel = "stylesheet" href="css/signup.css">
        <link rel = "stylesheet" href="css/placement.css">
        <link rel = "stylesheet" type="text" href="css/text.css">
        <script src = "simpleajax.js"></script>
        <script src = "room.js"></script>
    </head>
    <body>
        <div>
            <input id = "bouton" type = "submit" value = "+">

        <div class = "roomForm">
        </div>
        
        <div>
            Utilisateur <strong id = "utilisateur"><?php echo $login;?></strong>
            <a href="../Login/signout.php">Déconnexion</a>
            <br></br>
        </div>
        <div class = "Rooms">
        </div>

    </body>
</html>