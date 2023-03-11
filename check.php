<?php
session_start();
include 'connect.php';

if (!isset($pdo)) {
    $pdo = new PDO("mysql:host=localhost;dbname=todolist", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

if (isset($_POST['id'])) {
  $id = $_POST['id'];

  if (isset($_POST['completed']) && $_POST['completed'] === 'on') {
    $sql = "UPDATE todo SET status = 'completed' WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
  } else {
    $sql = "UPDATE todo SET status = '' WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
  }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
