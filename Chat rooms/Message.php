<?php
    session_start();
    class Message
    {
        private $message;
        private $time;
        private $messageArray;
        private $login;
        private $filepath;
        private $file;
        private $channel;

        public function __construct($message, $channel)
        {
            $this->message = $message;
            $this->channel = $channel;
            $this->time = date("H:i:s");
            $this->messageArray = array();
            $this->login = $_SESSION["login"];
            $this->filepath = "./Channels/messages.csv";
            $this->file = file($this->filepath, FILE_IGNORE_NEW_LINES);
            $this->createMessageCSV();
            //echo($this->encodedMessage());
        }

        private function createMessageCSV()
        {
            if(!file_exists($this->filepath))
            {
                $fp = fopen($this->filepath, "a+");
                fclose($fp);
            }
        }

        public function getMessage()
        {
            return $this->message;
        }

        public function getTime() 
        {
            return $this->time;
        }

        public function getChannel()
        {
            return $this->channel;
        }

        private function saveMessage() 
        {
            if($this->message!=="")
            {
                $newArray = array();
                $content = "";
                foreach($this->file as $line)
                {
                    $tokens = explode(",", $line);
                    if($tokens!=[""])
                    {
                        $newArray["message"] = $tokens[0];
                        $newArray["time"] = $tokens[1];
                        $newArray["user"] = $tokens[2];
                        $newArray["channel"] = $tokens[3];
                        $this->messageArray[] = $newArray;
                        $content.=implode(",", $tokens)."\n";
                    }
                }
                $content.=$this->message.",".$this->time.",".$this->login.",".$this->channel."\n";
                $this->messageArray[] = array(
                                "message" => $this->message,
                                "time" => $this->time,
                                "user" => $this->login,
                                "channel" => $this->channel
                );
                file_put_contents($this->filepath, $content);

            }
            return $this->messageArray;      
        }

        public function encodedMessage()
        {
            $this->saveMessage();
            $last = count($this->messageArray)-1;
            if($last>=0)
            {
                return json_encode($this->messageArray[$last]);
            }
            return json_encode("Pas de texte");
        }

    }
?>