<?php
session_start();
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
<?php
if (isset($_POST['submit'])) {
$naam = $_POST['naam'];
$pdoQuery =
    ' INSERT INTO `todo`(`naam`) VALUES (:naam)';
$pdoQuery_run = $conn->prepare($pdoQuery);
$pdoQuery_execc = $pdoQuery_run->execute([
    ':naam' => $naam
]);
}
$mirvat = $conn->prepare('SELECT * FROM todo');
$mirvat->execute();
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
<div class="flex flex-col items-center justify-center p-4 bg-white rounded-lg shadow-md">
  <div class="flex flex-col">
    <fom>
  <div class="mb-4">
            <h1 class="text-grey-darkest">To-do List</h1>
<div class="mx-auto w-11/12">
            <form action="" method="post">
            <div class="flex mt-4">
            <label for="naam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker" placeholder="Add Todo">
                <button type="submit" name="submit" class="flex-no-shrink p-2 border-2 rounded text-teal border-teal hover:bg-blue-100 ">Add</button>
            </div>
        </div>
        </form>

    <div class="flex">
<div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
    <div class="overflow-hidden">
    <table class="min-w-full">
        <thead class="border-b">
        <tr>
        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            #
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
           To-do
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            Tijd
            </th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            Status
            </th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $mirvat->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr class="bg-white border-b">
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?= $row['id'] ?>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?= $row['naam'] ?>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <a href="edit.php?id=<?= $row['id'] ?>">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</button>
</a>
        <a href="delete.php?id=<?= $row['id'] ?>"
           onclick="return confirm('Are you sure you want to delete this entry?')" class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Delete
        </a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</div>
</div>
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
   </body>

</html>