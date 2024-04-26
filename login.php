<?php
require_once (__DIR__ ."/utils/databaseManager.php");
include_once(__DIR__ . "/block/header.php");
include_once(__DIR__ . "/block/navbar.php");
$title = "Login";

$errors = [];
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["username"], $_POST["password"])
) {
    $pdo = connectDB();

    $response = $pdo->prepare("SELECT * FROM utilisateur WHERE username = :username");
    $response->execute(
        [
            ":username" => $_POST["username"]
        ]
    );
    $user = $response->fetch();

    if ($user !== false) {

        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
            $_SESSION["username"] = $_POST["username"];
            header("Location: http://localhost:8888/dauphine/admin/index.php");
        } else {
            $errors["global"] = "Invalid password or username.";
        }
    } else {
        $errors["global"] = "No input";
    }
}
?>

    <h1 class="text-center m-3"><?=$title?></h1>
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
include_once(__DIR__ . "/block/footer.php");
?>