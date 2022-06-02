<?php
    session_start();
    function roomForm()
    {
        $room ="<div>";
        $room.="<form method = 'post'>";
        $room.="<input type = 'text' name = 'newRoom'>";
        $room.="<input type = 'submit' value = 'Créer'>";
        $room.="</form>";
        $room.="</div>";
        return json_encode($room);
    }

    echo(roomForm());
?>