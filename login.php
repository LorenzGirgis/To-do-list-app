<?php
session_start();
include_once 'database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>

<body class="bg-gray-300">
    <div class="h-screen flex justify-center items-center w-full">
        <div class="bg-white px-10 py-16 rounded-xl w-screen shadow-md max-w-sm">
            <div class="space-y-12">
              <h1 class="text-3xl font-bold">Login</h1>

                <div>
                    <div class="space-y-12">
                        <div class="container">
                            <form action="includes/login.inc.php" method="POST">
                                <?php
                                $url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
                                if (strpos($url,"wrongpassword") !== false) {
                                    echo $_SESSION["wrongpassword"];
                                } else if (strpos($url,"accountnotfound") !== false) {
                                    echo $_SESSION["accountnotfound"];
                                }
                                ?>
                                <input type="text" name="email" placeholder="Email" required
                                    class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                        </div>
                    </div>

                    <div>
                        <br>

                        <div class="space-y-12">
                            <input type="password" name="password" placeholder="Wachtwoord" required
                                class="bg-indigo-50 px-4 py-2 outline-none rounded-md w-full" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" name="submit"
                            class="bg-indigo-500 text-white px-4 py-2 rounded-md w-full">Login</button>

                    <div class="mt-6 text-grey-dark">
                        <p>Nog geen account? <a class="text-blue-600 hover:underline"
                                href="register.php">Register</a></p>
                    </div>

                    <p>Terug naar <a class="text-blue-600 hover:underline" href="index.php">Home</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>