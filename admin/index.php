<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: http://localhost:8888/dauphine/index.php");
}
require_once ("../utils/databaseManager.php");
include_once("../block/header.php");
include_once("../block/navbar.php");
$pageName = "Page de l'administrateur";
$imageUrl = "";
$errors = [];

try {
    $pdo = connectDB();
    configPdo($pdo);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
//Traitement du téléchargement de fichiers
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imageUrl"])) {
    $file = $_FILES["imageUrl"];
    // Vérification des erreurs de téléchargement
    if ($file['error'] == UPLOAD_ERR_OK) {
        // Création d'un chemin d'accès pour l'enregistrement d'un fichier
        $uploadDir = "../img/";
        $uploadFile = $uploadDir . time() . '_' . basename($file["name"]);

        // Tentative d'enregistrement d'un fichier sur le serveur
        if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
            echo "<p class='text-success text-center'>Le fichier a été téléchargé avec succès.</p>";
            $imageUrl = substr($uploadFile, 3);
        } else {
            echo "<p class='text-danger text-center'>Échec du téléchargement du fichier.</p>";
        }
    } else {
        echo "<p class='text-danger text-center'>Erreur lors du téléchargement du fichier.</p>";
    }
}


//Traitement de l'ajout d'un article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"]) && isset($_POST["author"]) && isset($_POST["text"]) && isset($imageUrl)) {
    $title = htmlspecialchars($_POST["title"]);
    $author = htmlspecialchars($_POST["author"]);
    $text = htmlspecialchars($_POST["text"]);

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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteById"])) {
    $newsToDelete = $_POST["deleteById"];
    if (!empty($newsToDelete)) {
        $deletedRows = deleteNews($pdo, $newsToDelete);
        if ($deletedRows > 0) {
            echo ("<p class='text-success text-center'>L'information a été supprimée avec succès. $deletedRows articles supprimés au total</p>");
        } else {
            echo ("<p class='text-danger text-center'>Je n'ai pas trouvé d'article avec cet id.</p>");
        }
    } else {
        echo ("<p class='text-danger text-center'>L'id de l'article ne peut pas être vide.</p>");
    }
}
?>

    <h1 class="text-center m-3"><?=$pageName?></h1>
<a href="http://localhost:8888/dauphine/logout.php" class="btn btn-danger" style="position: fixed; top: 10px; right: 10px; z-index: 1500;">Déconnexion</a>
<!--    Formulaire d'ajout d'un article sur le site-->
    <h2 class="text-muted m-1 ms-5">Publier l'article</h2>
    <div class="d-flex flex-column justify-content-center ms-5">
        <form class="text-center p-1 col-6" method="POST" action="index.php" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="title" id="title" placeholder="title">
                <label for="title">Titre</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="author" id="author" placeholder="author">
                <label for="author">Auteur</label>
            </div>
            <div class="form-floating mb-3">
                <input type="file" class="form-control m-1 form-control-lg" name="imageUrl" id="imageUrl" placeholder="imageUrl" accept="image/*">
                <label for="imageUrl" class="form-label">Télécharger une image pour l'article</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control m-1" name="text" id="text" placeholder="text" style="height: 300px">
                <label for="text">Texte</label>
            </div>
            <input type="submit" class="btn btn-secondary m-1 mb-3 col-6" value="Publier">
            <?php
            if (isset($errors["global"])) {
                echo ("<p class='text-danger'>" .
                    $errors["global"] . "</p>");
            }
            ?>
        </form>
    </div>

<!--    Formulaire de suppression d'un article du site-->
    <h2 class="text-muted m-1 ms-5">Supprimer l'article (par #id)</h2>
    <div class="d-flex flex-column justify-content-center ms-5">
        <form class="text-center p-1 col-6" method="POST" action="index.php">
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="deleteById">#</span>
                    <input type="text" class="form-control" id="deleteById" name="deleteById" aria-describedby="deleteById basic-addon4">
                </div>
                <div class="form-text" id="basic-addon4">Saisissez le #id de l'article que vous souhaitez supprimer.</div>
            </div>
            <input type="submit" class="btn btn-secondary m-1 mb-3 col-6" value="Supprimer">
            <?php
            if (isset($errors["global"])) {
                echo ("<p class='text-danger'>" .
                    $errors["global"] . "</p>");
            }
            ?>
        </form>
    </div>

<!--    Lien vers le formulaire de modification d'article -->
    <h2 class="text-muted m-1 ms-5">Modifier l'article</h2>
    <div class="d-flex flex-column justify-content-center ms-5">
        <form class="text-center p-1 col-6" method="POST" action="edit.php">
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="articleId">#</span>
                    <input type="text" class="form-control" name="articleId" id="articleId" aria-describedby="articleId basic-addon4">
                </div>
                <div class="form-text" id="basic-addon4">Saisissez # id de l'article que vous souhaitez modifier.</div>
            </div>
            <input type="submit" class="btn btn-secondary m-1 mb-3 col-6" value="Modifier">
        </form>
    </div>

<?php
include_once("../block/footer.php");
?>