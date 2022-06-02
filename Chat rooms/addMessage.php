<?php
    include("Message.php");
    $text = $_GET["message"];
    $currentRoom = $_GET["currentRoom"];
    $_SESSION["message"] = $text;
    $_SESSION["currentRoom"] = $currentRoom;
    $message = new Message($text, $currentRoom);
    echo($message->encodedMessage());
?>