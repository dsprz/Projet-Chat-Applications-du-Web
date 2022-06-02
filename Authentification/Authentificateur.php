<?php
    session_start();
    class Authentificateur
    {
        private $goodLength;
        private $login;
        private $password;
        private $confirmedPassword;
        private $userFile;
        private $goodUsername = true;
        private $allUsers;
        private $allInfos;
        private $pathToUsers;
        private $ids;
        
        public function __construct(string $login, string $password, string $confirmedPassword="", int $goodLength = 4)
        {
            $this->pathToUsers = "users.csv";
            $this->login = $login;
            $this->password = $password;
            $this->confirmedPassword = $confirmedPassword;
            $this->goodLength = $goodLength;
            $this->userFile = file($this->pathToUsers, FILE_IGNORE_NEW_LINES);
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function getConfirmedPassword(): string
        {
            return $this->confirmedPassword;
        }

        private function goodLogin(): bool
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

        private function goodPasswordLength()
        {
            if(strlen($this->password)>=$this->goodLength)
            {
                return true;
            }
            header("location: signup.php?badsignup=3");
        }

        private function samePasswords()
        {
            if($this->confirmedPassword == $this->password)
            {
                return true;
            }
            header("location: signup.php?badsignup=4");
        }

        private function allUsers(): array
        {
            $this->allUsers = array();
            foreach($this->userFile as $line)
            {
                $tokens = explode(",", $line);
                $this->allUsers[] = $tokens[0];
            }
            return $this->allUsers;
        }

        private function allInfos(): array
        {
            $this->allInfos = array();
                foreach($this->userFile as $line)
                {
                    $tokens = explode(",", $line);
                    $this->allInfos[] = $tokens; 
                }
            return $this->allInfos;
        }

        private function writeInUserFile()
        {
            $allInfos = $this->allInfos();
            $content = "";
            foreach($allInfos as $infos)
            {
                $content.=implode(",", $infos)."\n";
            }
            $content.=$this->login.",".$this->password;
            file_put_contents($this->pathToUsers, $content);
        }

        public function addUser()
        {
            if($this->goodLogin() && $this->goodPasswordLength() && $this->samePasswords())
            {   
                mkdir("./Users/".$this->login);
                mkdir("../Chat Rooms/Users/".$this->login);
                $this->writeInUserFile();
                $this->ids[$this->login] = $this->password; 
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

        public function checkIds(): bool
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
            return $userWasFound && $goodPassword;
        }

        public function signIn()
        {   
            if($this->checkIds())
            {
                $_SESSION["login"] = $this->login;
                header("location: ../Chat Rooms/app.php");
            }
            else
            {
                header("location: signin.php?badsignin=1");

            }
        }

        public function deleteRegistration()
        {
            if($this->checkIds() && $this->samePasswords())
            {
                $allInfos = $this->allInfos();
                //delete le dossier de l'utilisateur
                rmdir("Users/".$this->login);
                //enleve l'user du tableau des users
                for($i=0; $i<count($this->allUsers); $i++)
                {
                    if($this->allUsers[$i]==$this->login)
                    {
                        array_splice($this->allUsers,$i,$i);
                        break;
                    }
                }
                //enleve l'user et le mot de passe associé
                for($i=0; $i<count($allInfos); $i++)
                {
                    for($j=0; $j<count($allInfos[$i]); $j++)
                    {
                        if($allInfos[$i][$j] == $this->login)
                        {
                            array_slice($allInfos[$i], $i, $i);
                        }
                    }
                }
                $this->allInfos = $allInfos;
                unset($this->ids[$this->login]);

                $content = "";
                foreach($this->userFile as $line){
                    $tokens = explode(",", $line);
                    if($tokens[0]!=$this->login)
                    {
                        $content.=implode(",", $tokens)."\n";
                    }
                }
                file_put_contents($this->pathToUsers, $content);
            }
            else
            {
                if(!$this->checkIds())
                {
                    header("location: deleteForm.php?badlogin=1");
                }
                if(!$this->samePasswords())
                {
                    header("location: deleteForm.php?badlogin=2");
                }
            }
        }

        private function clearAllUsers()
        {
            file_put_contents($this->userFile, "");
        }

    }

?>

