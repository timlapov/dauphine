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



<?php
include_once("../block/footer.php");
?>