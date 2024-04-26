<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: http://localhost:8888/dauphine/index.php");
}
require_once ("../utils/databaseManager.php");
include_once("../block/header.php");
include_once("../block/navbar.php");
$title = "Admin Panel";
$errors = [];
?>

    <h1 class="text-center m-3"><?=$title?></h1>
<a href="http://localhost:8888/dauphine/logout.php" class="btn btn-danger" style="position: fixed; top: 10px; right: 10px; z-index: 1500;">Log out</a>

    <div class="d-flex flex-column justify-content-center align-items-center">
        <form class="text-center p-5 col-5" method="POST" action="login.php">
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="username" id="username" placeholder="user">
                <label for="username">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control m-1" name="password" id="password" placeholder="password">
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn btn-secondary m-1" value="Login">
            <?php
            if (isset($errors["global"])) {
                echo ("<p class='text-danger'>" .
                    $errors["global"] . "</p>");
            }
            ?>
        </form>
    </div>


<?php
include_once("../block/footer.php");
?>