<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: http://localhost:8888/dauphine/index.php");
}
require_once ("../utils/databaseManager.php");
include_once("../block/header.php");
include_once("../block/navbar.php");
$title = "Page de l'administrateur";
$errors = [];

try {
    $pdo = connectDB();
    configPdo($pdo);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

//Traitement de l'ajout d'un article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"]) && isset($_POST["author"]) && isset($_POST["text"]) && isset($_POST["imageUrl"])) {
    $title = htmlspecialchars($_POST["title"]);
    $author = htmlspecialchars($_POST["author"]);
    $text = htmlspecialchars($_POST["text"]);
    $imageUrl = htmlspecialchars($_POST["imageUrl"]);

    if (!empty(trim($title)) && !empty(trim($author)) && !empty(trim($text)) && !empty(trim($imageUrl))) {
        $addedNews = addNews($pdo, $title, $author, $text, $imageUrl);
        if ($addedNews == 1) {
            echo ("<p class='text-success text-center'>L'information a été ajouté avec succès.</p>");
        }
    } else {
        echo ("<p class='text-danger text-center'>Remplir tous les champs pour ajouter un article !</p>");
    }

}

//Traitement suppression d'un article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteByTitle"])) {
    $newsToDelete = $_POST["deleteByTitle"];
    if (!empty($newsToDelete)) {
        $deletedRows = deleteNews($pdo, $newsToDelete);
        if ($deletedRows > 0) {
            echo ("<p class='text-success text-center'>L'information a été supprimée avec succès. $deletedRows articles supprimés au total</p>");
        } else {
            echo ("<p class='text-danger text-center'>Je n'ai pas trouvé d'article avec ce titre.</p>");
        }
    } else {
        echo ("<p class='text-danger text-center'>Le titre de la nouvelle ne peut pas être vide.</p>");
    }
}
?>

    <h1 class="text-center m-3"><?=$title?></h1>
<a href="http://localhost:8888/dauphine/logout.php" class="btn btn-danger" style="position: fixed; top: 10px; right: 10px; z-index: 1500;">Déconnexion</a>

    <h2 class="text-muted m-1 ms-5">Publier l'article</h2>
    <div class="d-flex flex-column justify-content-center ms-5">
        <form class="text-center p-1 col-6" method="POST" action="index.php">
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="title" id="title" placeholder="title">
                <label for="title">Titre</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="author" id="author" placeholder="author">
                <label for="author">Auteur</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="imageUrl" id="imageUrl" placeholder="imageUrl">
                <label for="imageUrl">Lien vers l'image</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="text" id="text" placeholder="text" style="height: 300px">
                <label for="text">Texte</label>
            </div>
            <input type="submit" class="btn btn-secondary m-1 col-6" value="Publier">
            <?php
            if (isset($errors["global"])) {
                echo ("<p class='text-danger'>" .
                    $errors["global"] . "</p>");
            }
            ?>
        </form>
    </div>

    <h2 class="text-muted m-1 ms-5">Supprimer l'article (par titre)</h2>
    <div class="d-flex flex-column justify-content-center ms-5">
        <form class="text-center p-1 col-6" method="POST" action="index.php">
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="deleteByTitle" id="deleteByTitle" placeholder="deleteByTitle">
                <label for="deleteByTitle">Titre</label>
            </div>
            <input type="submit" class="btn btn-secondary m-1 col-6" value="Supprimer">
            <?php
            if (isset($errors["global"])) {
                echo ("<p class='text-danger'>" .
                    $errors["global"] . "</p>");
            }
            ?>
        </form>
    </div>

    <h2 class="text-muted m-1 ms-5">Modifier l'article</h2>



<?php
include_once("../block/footer.php");
?>