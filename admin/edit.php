<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: http://localhost:8888/dauphine/index.php");
}
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
            $newImageUrl = substr($uploadFile, 3);
        } else {
            echo "<p class='text-danger text-center'>Échec du téléchargement du fichier.</p>";
        }
    }
}

//Traitement de la modification d'un article
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"]) && isset($_POST["author"]) && isset($_POST["content"]) && isset($_POST["articleId"]) && (isset($newImageUrl) || isset($_POST["currentImageUrl"]))) {
    $title = htmlspecialchars($_POST["title"]);
    $author = htmlspecialchars($_POST["author"]);
    $content = htmlspecialchars($_POST["content"]);
    $imageUrl = empty($newImageUrl) ? htmlspecialchars($_POST["currentImageUrl"]) : $newImageUrl;
    $id = (int) $_POST["articleId"];
    if (!empty(trim($title)) && !empty(trim($author)) && !empty(trim($content)) && !empty(trim($imageUrl))) {
        $updatedNews = updateNews($pdo, $id, $title, $author, $content, $imageUrl);
        if ($updatedNews == 1) {
            echo ("<p class='text-success text-center'>L'information a été modifié avec succès.</p>");
        }
    } else {
        echo ("<p class='text-danger text-center'>Remplir tous les champs pour modifier un article !</p>");
    }

}

//Obtention d'un article d'identification ou d'une démonstration d'erreur
if (isset($_POST["articleId"])) {
    $id = $_POST["articleId"];
    $id = (int) trim($id);
    if (!empty($id)) {
        $article = getOneNews($pdo, $id);
        if (empty($article)) {
            echo ("<p class='text-danger text-center'>Il n'y a pas d'article avec cet id !</p>");
        }
    } else {
        echo ("<p class='text-danger text-center'>Le champ ne peut pas être vide !</p>");
    }
}
?>

    <h1 class="text-center m-3"><?=$pageName?></h1>

<?php
//Appeler le formulaire de modification d'un article s'il existe un article avec cet identifiant
if (!empty($article)) {
    include_once "../block/editForm.php";
} else {
    echo ('
               <div class="m-3 text-center col-12">
        <a href="index.php" class="btn btn-danger">Accéder à la page d\'administration</a>
    </div> 
    ');
}
?>

<?php
include_once("../block/footer.php");
?>