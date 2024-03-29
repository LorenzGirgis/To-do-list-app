<?php
session_start();
include 'connect.php';
if (isset($_POST['submit'])) {
    if (isset($_POST['naam'])) {
        $naam = $_POST['naam'];
        $pdoQuery = 'INSERT INTO `todo`(`naam`)     VALUES (:naam)';
        $pdoQuery_run = $conn->prepare($pdoQuery);
        $pdoQuery_exec = $pdoQuery_run->execute(array(':naam' => $naam));
    }
   
}
$mirvat = $conn->prepare('SELECT * FROM todo ORDER BY id ASC');
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
  <style>
    .completed {
      text-decoration: line-through;
    }
  </style>
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
<div class="flex flex-col items-center justify-center p-4 bg-white rounded-lg shadow-md">
  <div class="flex flex-col">
  <div class="mb-4">
            <form class="bg-white p-6 rounded-lg shadow-md" method="POST" action="index.php">
    <div class="mb-4">
    <h1 class="text-grey-darkest">To-do List</h1>
    <br>
        <label class="block text-gray-700 font-bold mb-2" for="naam">
            To-do:
        </label>
        <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="naam" id="naam" required>
    </div>
    <div class="flex items-center justify-between">
        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="submit" value="Submit">
    </div>                      
</form>
<?php
include 'pagination.php';
?>
<div class="flex">
<div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
    <div class="overflow-hidden">
    <table class="min-w-full">
        <thead class="border-b">
        <tr>
        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
            Completed
            </th>
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
<?php while ($row = $mirvat->fetch(PDO::FETCH_ASSOC) ) {?>
    <tr class="bg-white border-b">
        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <form action="check.php" method="POST">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="checkbox" name="completed" <?php if($row['status'] == 'completed') echo 'checked'; ?> onchange="this.form.submit();"> Completed
            </form>
        </td>
        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?= $row['id'] ?>
        </td>
        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <?php if($row['status'] == 'completed') {?>
                <del><?= $row['naam'] ?></del>
            <?php } else {?>
                <?= $row['naam'] ?>
            <?php } ?>
        </td>
        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
    <?= date('H:i:s', strtotime($row['tijd'])) ?> <?= date('d-m-Y', strtotime($row['tijd'])) ?>
</td>
        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
            <a href="edit.php?id=<?= $row['id'] ?>">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</button>
            </a>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this entry?')" class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Delete</a>
        </td>
    </tr>
<?php } ?>
</tbody>
</table>
<div class="flex justify-center my-4">
    <div class="flex">
        <?php if ($page > 1) {?>
            <a href="?page=<?= $page-1 ?>" class="px-3 py-1 bg-gray-200 rounded-md mr-1 hover:bg-gray-300">Prev</a>
        <?php } ?>
        
        <?php for ($i=1; $i<=$num_pages; $i++) {?>
            <a href="?page=<?= $i ?>" class="<?php if($page==$i) echo 'bg-gray-500 text-white'; else echo 'bg-gray-200 text-gray-700'; ?> px-3 py-1 rounded-md mx-1 hover:bg-gray-300"><?= $i ?></a>
        <?php } ?>
        
        <?php if ($page < $num_pages) {?>
            <a href="?page=<?= $page+1 ?>" class="px-3 py-1 bg-gray-200 rounded-md ml-1 hover:bg-gray-300">Next</a>
        <?php } ?>
    </div>
</div>

</div>
</div>
</div>
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
   </body>
</html>
