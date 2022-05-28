<?php
    class Authentificateur
    {
        private $goodLength;
        private $login;
        private $password;
        private $confirmedPassword;
        private $userFile;
        private $goodUsername = true;
        private $ids;
        
        public function __construct(string $login, string $password, string $confirmedPassword="", int $goodLength = 4)
        {
            $this->login = $login;
            $this->password = $password;
            $this->confirmedPassword = $confirmedPassword;
            $this->goodLength = $goodLength;
            $this->userFile = file("users.csv", FILE_IGNORE_NEW_LINES);
        }

        public function goodLogin(): bool
        {
            $users = $this->allUsers();
            if(!ctype_alpha($this->login))
            {
                $this->goodUsername = false;
                header("location: signup.php?badsignup=1");
            }
            foreach($users as $user)
            {
                if($user==$this->login)
                {
                    $this->goodUsername = false;
                    header("location: signup.php?badsignup=2"); 
                    break;
                }
            }
            return $this->goodUsername;
        }

        public function goodPasswordLength(): bool
        {
            if(strlen($this->password)<=$this->goodLength)
            {
                return true;
            }
            header("location: signup.php?badsignup=3");
        }

        public function samePasswords(): bool
        {
            if($this->confirmedPassword == $this->password)
            {
                return true;
            }
            header("location: signup.php?badsignup=4");
        }

        public function allUsers(): array
        {
            $allUsers = array();
            foreach($this->userFile as $line)
            {
                $tokens = explode(",", $line);
                $allUsers[] = $tokens[0];
            }
            return $allUsers;
        }

        public function allInfos(): array
        {
            $allInfos = array();
                foreach($this->userFile as $line)
                {
                    $tokens = explode(",", $line);
                    $allInfos[] = $tokens; 
                }
            return $allInfos;
        }

        public function writeInUserFile()
        {
            $allInfos = $this->allInfos();
            $content = "";
            foreach($allInfos as $infos)
            {
                $content.=implode(",", $infos)."\n";
            }
            $content.=$this->login.",".$this->password;
            file_put_contents("users.csv", $content);
        }

        public function addUser()
        {
            if($this->goodLogin() && $this->goodPasswordLength() && $this->samePasswords())
            {
                $this->writeInUserFile();
                $this->ids[$login] = $password; 
                header("location: signin.php");
            }
        }
        private function setIds()
        {
            foreach($this->userFile as $line)
            {
                $tokens = explode(",", $line);
                $this->ids[$tokens[0]] = $tokens;
            }
        }
        public function signIn()
        {   
            $this->setIds();
            $userWasFound = false;
            $goodPassword = false;
            foreach($this->allUsers() as $user)
            {
                if($user == $this->login)
                {
                    $userWasFound = true;
                    break;
                }
            }
            foreach($this->ids as $username=>$password)
            {
                if($this->ids[$this->login] == $this->ids[$username])
                {
                    $goodPassword = true;
                    break;
                }
            }
            if($userWasFound && $goodPassword)
            {
                header("location: ../Chat Rooms/app.php");
            }
            else
            {
                header("location: signin.php?badsignin=1");

            }
        }
    }

?>

