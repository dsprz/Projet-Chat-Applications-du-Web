<?php
    session_start();
    class Room{
        private $name;
        private $chatFile;

    public function __construct($name)
    {
        $this->name = $name;
        $this->chatFile = fopen("php://output", "wb");
        $this->createCSV();
    }

    private function createCSV()
    {
        //header("Content-Type: text/csv");
        //header("Content-Disposition: attachment; filename='$this->name.csv'");
        $fp = fopen("Channels/".$this->name.".csv", "w");
        fclose($fp);
    }
    public function chatBox()
    {
        $chatbox = "<input type ='text' name = 'chatbox'>";
        $chatbox.= "<input type = 'submit' value = 'Envoyer'>";
        return $chatbox;
    }
}
$roomName = $_POST["newRoom"];
$newRoom = new Room($roomName);
echo($newRoom->chatBox());