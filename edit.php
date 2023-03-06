<?php
session_start();
include 'connect.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM todo WHERE id = :id");
$stmt->execute(['id' => $id]);
$row = $stmt->fetch();
$naam = $row['naam'];
$tijd = $row['tijd'];

if (isset($_POST['submit'])) {
    $naam = $_POST['naam'];
    $sql = 'UPDATE todo SET id=:id, naam=:naam, tijd=:tijd WHERE id=:id';
    $statement = $conn->prepare($sql);
    if ($statement->execute([':id' => $id, ':naam' => $naam, ':tijd' => $tijd])) {
        header("Location: index.php");
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit-todo</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </div>
    </div>
    </header>
    <br>
    <h1 class="flex justify-center">To-do editen</h1>
    <br>
    <form class="flex justify-center" action="" method="POST">
        <div class=" mb-6 md:grid-cols-8">
            <div>

                <label for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">id</label>
                <input type="text" name="id" value="<?php echo $id ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Naam" disabled>
            </div>
            <div>
                <label for="naam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To-do</label>
                <input type="text" name="naam" value="<?php echo $naam ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Naam" required>
            </div>
            <div>
                <label for="tijd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tijd</label>
                <input type="text" name="tijd" value="<?php echo $tijd ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tijd" disabled>
            </div>
            <div>
                <button type="submit" name="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-7">Submit</button>
            </div>
        </div>
    </form>
</body>

</html>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> 