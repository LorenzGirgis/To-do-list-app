<?php

class RegisterController extends Register {

    private $username;
    private $email;
    private $password;
    private $repeatpassword;

    public function __construct($username,   $email, $password, $repeatpassword) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->repeatpassword = $repeatpassword;
    }

    public function registerUser() {
        session_start();
        if ($this->emptyInput() == false) {
            header("Location: ../register.php?error=emptyinput");
            exit();
        } else if ($this->passwordLength() == false) {
            $_SESSION["passwordlength"] = "Wachtwoord moet minimaal 8 tekens bevatten!";
            header("Location: ../register.php?error=passwordlength");
            exit();
        }else if ($this->invalidUsername() == false) {
            $_SESSION["invalidusername"] = "Username is invalid!";
            header("Location: ../register.php?error=invalidusername");
            exit();
        } else if ($this->invalidEmail() == false) {
            header("Location: ../register.php");
            exit();
        } else if ($this->passwordMatch() == false) {
            $_SESSION["passwordmatch"] = "Watwoorden komen niet overeen!";
            header("Location: ../register.php?error=passwordmatch");
            exit();
        } else if ($this->checkUsername() == false) {
            $_SESSION["checkusername"] = "Username bestaat al!";
            header("Location: ../register.php?error=checkusername");
            exit();
        }

        $this->setUser($this->username, $this->email, $this->password,);
    }

    private function emptyInput() {
        $result;
        if (empty($this->username) || empty($this->email) || empty($this->password) || empty($this->repeatpassword)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function passwordLength() {
        $result;
        if (strlen($this->password) < 8) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidUsername() {
        $result;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail() {
        $result;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function passwordMatch() {
        $result;
        if ($this->password !== $this->repeatpassword) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function checkUsername() {
        $result;
        if (!$this->checkUser($this->username, $this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

}

?>
