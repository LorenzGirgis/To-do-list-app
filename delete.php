<?php
include 'connect.php';
$id = $_GET['id'];
$sql = 'DELETE FROM todo WHERE id=:id';
$statement = $conn->prepare($sql);
if ($statement->execute([':id' => $id])) {
    header("Location: index.php");
}