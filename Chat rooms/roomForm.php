<?php
    function roomForm()
    {
        $room ="<div>";
        $room.="<form action = 'room.php' method = 'post'>";
        $room.="<input type = 'text' name = 'newRoom'>";
        $room.="<input type = 'submit' value = 'Créer'>";
        $room.="</form>";
        $room.="</div>";
        return $room;
    }

    echo(roomForm());