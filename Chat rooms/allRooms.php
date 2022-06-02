<?php
    session_start();
    $channels = file("./Channels/channels.csv", FILE_IGNORE_NEW_LINES);

    function allChannels($channels)
    {
        $login = $_SESSION["login"];
        foreach($channels as $channel)
        {
            $c = explode(",", $channel);
            if($login === $c[0])
            {
                $allChannels = array_slice($c, 1, count($c)-1);
                break;
            }
        }
        if(isset($allChannels))
        {
            foreach($allChannels as $key =>$value)
            {
                $allChannels[(string)$key] = $allChannels[$key];
                //echo($allChannels["$key"]);
                //unset($allChannels[$key]);
                //echo($allChannels["$key"]);
            }
                return json_encode($allChannels);
        }
        else{
            return json_encode("Pas de channel");
        }
        
    }
    echo(allChannels($channels));
?>  
