<?php
session_start();
if (isset($_SESSION["username"])) {
    if ($_SESSION["username"] == "Admin") {
        $_SESSION["username"];
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}

?>
<?php
$dsn = "mysql:dbname=todolist;host=localhost";
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
try {
    $conn = new PDO("mysql:host=$servername;dbname=todolist", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.4.6/tailwind.min.css">
    <title>To-do list</title>
</head>
<body>
<nav class="flex items-center justify-between px-4 py-3 bg-teal-500">
  <div class="flex items-center font-semibold text-white">
    To-Do List
  </div>
  <div class="flex items-center">
  <div class="form">
                        <?php
                        if (isset($_SESSION["userid"])) {
                            if ($_SESSION["username"] === "Admin") {
                                $present_time = date("H:i:s-m/d/y");
                                $expiry = 60*24*60*60+time();
                               setcookie("last_visit", $present_time, $expiry);
                                   if (isset($_COOKIE["last_visit"])) {
                                       $last_visit = $_COOKIE["last_visit"];
                                       $last_seen = $conn->prepare("UPDATE users SET last_seen = ? WHERE id = ?");
                                       $last_seen->execute([$last_visit, $_SESSION["userid"]]);
                                   }   
                               ?>
                        <a href="admin.php" class="mr-4">Admin</a>
                        <a href="includes/logout.inc.php">Logout</a>
                        <?php   
                            } else {
                                $present_time = date("H:i:s-m/d/y");
                                $expiry = 60*24*60*60+time();
                               setcookie("last_visit", $present_time, $expiry);
                                   if (isset($_COOKIE["last_visit"])) {
                                       $last_visit = $_COOKIE["last_visit"];
                                       $last_seen = $conn->prepare("UPDATE users SET last_seen = ? WHERE id = ?");
                                       $last_seen->execute([$last_visit, $_SESSION["userid"]]);
                                   }   
                               ?>
                                <a class="mr-4"><?= $_SESSION["username"] ?></a>
                                <a href="includes/logout.inc.php">Logout</a>
                        <?php
                            }
                        } else {
                        ?>
                        <a href="login.php"
                        class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                        href="login.php">Login</a>
                        <?php
                        }
                        ?>
                    </div>
  </div>
</nav>
</body>
</html>