<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$sql = "SELECT * FROM `todo` ORDER BY `id` ASC LIMIT $limit OFFSET $offset";
$mirvat = $conn->prepare($sql);
$mirvat->execute();

$count_sql = "SELECT COUNT(*) FROM `todo`";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->execute();
$count = $count_stmt->fetchColumn();

$num_pages = ceil($count / $limit);
?>