<?php
    session_start();
    function getAllMessages()
    {
        $file = file("./Channels/messages.csv", FILE_IGNORE_NEW_LINES);
        $allMessages = array();
        foreach($file as $tokens)
        {
            $tokens = explode(",", $tokens);
            $allMessages[] = $tokens;
        }
        return json_encode($allMessages);
    }
    echo(getAllMessages());
