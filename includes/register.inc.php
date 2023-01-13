<?php
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatpassword = $_POST["repeatpassword"];

    include "../database.php";
    include "../classes/register.classes.php";
    include "../classes/register-controller.classes.php";
    $register = new RegisterController($username, $email, $password, $repeatpassword);

    $register->registerUser();

    header("Location: ../login.php");
}
?>
