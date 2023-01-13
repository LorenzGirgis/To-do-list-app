<?php

class Register extends DB {

    protected function setUser($username, $email, $password,) {
        $stmt = $this->connect()->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->execute(array(':username' => $username, ':email' => $email, ':password' => $hashedPassword,))) {
            $stmt = null;
            header("Location: ../index.php?error=sqlerror");
            exit();
        }


        $stmt = null;
    }

    protected function checkUser($username, $email) {
        $stmt = $this->connect()->prepare("SELECT username FROM users WHERE username = ? OR email = ?");

        if (!$stmt->execute(array($username, $email))) {
            $stmt = null;
            header("Location: ../index.php?error=sqlerror");
            exit();
        }

        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }
        return $resultCheck;
    }

}

?>
