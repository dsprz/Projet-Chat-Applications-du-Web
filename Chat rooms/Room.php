<?php
    session_start();
    class Room
    {
        private $name;
        private $chatFile;
        private $roomsFile;
        private $login;
        private $allRooms;
        private $file;
        private $pathToChannels;

        public function __construct($name="")
        {
            $this->name = $name;
            //$this->createCSV();
            $this->login = $_SESSION["login"];
            //$this->filepath = "./Users/".$this->login."/".$this->login.".csv";
            //$this->createDirectory();
            //$this->createCSV($this->filepath);
            $this->pathToChannels = "./Channels/channels.csv";
            //$this->file = file($this->filepath, FILE_IGNORE_NEW_LINES);
            $this->createCSV($this->pathToChannels);
            $this->addUserInFile();
            $this->addRoomInFile();
        }

        private function createCSV($filename)
        {
            if(!file_exists($this->pathToChannels))
            {
                echo($this->pathToChannels);
                $fc = fopen($this->pathToChannels, "a+");
                fclose($fc);
            }
        }
        public function chatBox()
        {
            $chatbox = "<input type ='text' name = 'chatbox'>";
            $chatbox.= "<input type = 'submit' value = 'Envoyer'>";
            return $chatbox;
        }
        public function getRoomName()
        {
            return $this->name;
        }

        public function json_room()
        {
            $arr = array("name" => $this->name);
            return json_encode($arr);
        }

        public function allContent()
        {
            $content = "";
            $file = file($this->pathToChannels, FILE_IGNORE_NEW_LINES); 
            foreach($file as $line)
            {
                $tokens = explode(",", $line);
                $content.=implode(",", $tokens)."\n";
                
            }
            return $content;
        }

        public function addUserInFile()
        {
            $content = "";
            $file = file($this->pathToChannels, FILE_IGNORE_NEW_LINES); 
    
            foreach($file as $line)
            {
                $tokens = explode(",", $line);
                if($tokens[0] === $this->login)
                {
                    return false;
                }
                //Si c'est le premier user :
                if(count($tokens) == 1)
                {
                    $content.=implode(",", $tokens);
                } 
                else
                {   
                    $content.=implode(",", $tokens)."\n";
                }
                
            }
            $content.=$this->login;
            file_put_contents($this->pathToChannels, $content);
        }

        public function roomExistsForCurrentUser(){
            $file = file($this->pathToChannels, FILE_IGNORE_NEW_LINES); 
            $roomAlreadyExistsForCurrentUser = false;
            foreach($file as $line)
            {
                $tokens = explode(",", $line);
                if($tokens[0] == $this->login)
                {
                    $slice = array_slice($tokens, 1, count($tokens)-1);
                    break;
                }
            }

            if(isset($slice))
            {
                foreach($slice as $room)
                {
                    if($this->name === $room)
                    {
                        $roomAlreadyExistsForCurrentUser = true;
                        break;
                    }
                }
            }
            return $roomAlreadyExistsForCurrentUser;
        }

        public function addRoomInFile()
        {
            $content ="";
            $file = file($this->pathToChannels, FILE_IGNORE_NEW_LINES); 
            foreach($file as $line)
            {   
                $tokens = explode(",", $line);
                if($tokens[0] === $this->login)
                {
                    $tokens[] = $this->name;
                }
                $content.=implode(",", $tokens)."\n";
            }
            if(!$this->roomExistsForCurrentUser())
            {
                file_put_contents($this->pathToChannels, $content);
            }
        }
    
    }

?>