<?php
class DB {

    protected function connect() {
          $server = "localhost";
          $username = "root"; // bit_academy
          $password = ""; // bit_academy
          $dbname = "todolist";
          
          try {
               $conn = new PDO(
                    "mysql:host=$server; dbname=$dbname",
                    "$username", "$password"
               );
               
               $conn->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
               );
               return $conn;
          }
          catch(PDOException $e) {
               die('Unable to connect with the database');
          }
          
     }
     
     public function submit($naam) {
          $stmt = $this->connect()->prepare('INSERT INTO `todo`(`naam`) VALUES (:naam)');
          $stmt->bindParam(':naam', $naam);
          $stmt->execute();
          return $stmt;
     }

     public function getRegistered() {
     $stmt = $this->connect()->prepare('SELECT COUNT(`username`) FROM `users` LIMIT 3 OFFSET 0');
     $stmt->execute();
     return $stmt;     
}
}
?>