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
public function getRegistered() {
     $stmt = $this->connect()->prepare('SELECT COUNT(`username`) FROM `users` LIMIT 3 OFFSET 0');
     $stmt->execute();
     return $stmt;
}
}

function pdo_connect_mysql() {
     $DATABASE_HOST = 'localhost';
     $DATABASE_USER = 'root';
     $DATABASE_PASS = '';
     $DATABASE_NAME = 'todolist';
     try {
          return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
     } catch (PDOException $exception) {
          exit('Failed to connect to database!');
     }
 }

 
?>
