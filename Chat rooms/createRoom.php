<?php
    include("Room.php");
    $roomName = $_GET["roomName"];
    $newRoom = new Room($roomName);
    //$newRoom->addRoomInFile();
    $_SESSION["roomName"] = $newRoom->getRoomName();
    echo(json_encode($newRoom->getRoomName()));
    //print_r($newRoom->allRooms());
    //echo("La nouvelle room est : ".$newRoom->addRoomInFile());
    //print_r($newRoom->addRoomInFile());
    //header("location: app.php");
?>