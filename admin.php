<?php
session_start();
include 'connect.php';
if (isset($_SESSION["email"])) {
    if ($_SESSION["email"] == "admin@gmail.com") {
        $_SESSION["email"];
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
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
    <a href="index.php">
  <div class="flex items-center font-semibold text-white">
    To-Do List
  </div>
</a>
  <div class="flex items-center">
  <div class="form">
                        <?php
                        if (isset($_SESSION["email"])) {
                            if ($_SESSION["email"] === "admin@gmail.com") {
                                $present_time = date("H:i:s-m/d/y");
                                $expiry = 60*24*60*60+time();
                               setcookie("last_visit", $present_time, $expiry);
                                   if (isset($_COOKIE["last_visit"])) {
                                       $last_visit = $_COOKIE["last_visit"];
                                       $last_seen = $conn->prepare("UPDATE users SET last_seen = ? WHERE id = ?");
                                       $last_seen->execute([$last_visit, $_SESSION["userid"]]);
                                   }   
                               ?>
                        <a href="admin.php" class="mr-4"><?= $_SESSION["username"] ?></a>
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
<br>
<h1 class="flex justify-center"> Users </h1>
<div class="flex justify-center place-items-center p-3">
    <div class="flex justify-evenly font-bold text-xs bg-white border-b-2 border-gray-200 rounded-lg w-[115%] h-2/5 p-5 lg:w-2/5 p-3">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Naam</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Last seen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = $conn->prepare("SELECT * FROM users");
                $users->execute();
                $users = $users->fetchAll();
                foreach ($users as $user) {
                ?>
                <tr>
                    <td class="border border-gray-300 px-4 py-2"><?= $user["username"] ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= $user["email"] ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?= $user["last_seen"] ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
