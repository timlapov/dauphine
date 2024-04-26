<?php
require_once ("../utils/databaseManager.php");
include_once("../block/header.php");
include_once("../block/navbar.php");
$pageName = "Modification de l'article";

$errors = [];

try {
    $pdo = connectDB();
    configPdo($pdo);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

if (isset($_GET["editByTitle"])) {
    $title = $_GET["editByTitle"];
    if (!empty(trim($title))) {
        $article = getOneNews($pdo, $title);
    }
    if (empty($article)) {
        echo ("<p class='text-danger text-center'>Il n'y a pas d'article avec ce titre !</p>");
    }
}
?>

    <h1 class="text-center m-3"><?=$pageName?></h1>
<form class="text-center p-1 col-6" method="POST" action="edit.php">
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text" id="deleteByTitle">Titre : </span>
            <input type="text" class="form-control" id="deleteByTitle" name="deleteByTitle" aria-describedby="deleteByTitle basic-addon4">
        </div>
        <div class="form-text" id="basic-addon4">Saisissez le titre de l'article que vous souhaitez supprimer.</div>
    </div>
    <!--            <div class="form-floating mb-3">-->
    <!--                <input type="text" class="form-control m-1" name="deleteByTitle" id="deleteByTitle" placeholder="deleteByTitle">-->
    <!--                <label for="deleteByTitle">Titre</label>-->
    <!--            </div>-->
    <input type="submit" class="btn btn-secondary m-1 mb-3 col-6" value="Supprimer">

</form>

<div class="m-3 text-center">
<a href="index.php" class="btn btn-danger">Accéder à la page d'administration</a>
</div>
<?php
//var_dump($_GET);
//var_dump($article);
include_once("../block/footer.php");
?>