<?php
require_once("utils/databaseManager.php");
include_once(__DIR__ . "/block/header.php");
include_once(__DIR__ . "/block/navbar.php");
$title = "Bienvenue sur notre site d'actualités";

try {
    $pdo = connectDB();
    configPdo($pdo);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

$news = getAllNews($pdo);
?>

<h1 class="text-center m-3"><?=$title?></h1>

<!--<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">-->
<div class="d-flex flex-column justify-content-center align-items-center">
    <?php foreach ($news as $newsItem) { ?>
<div class="card m-3 col-6">
    <img src=<?=$newsItem['imageUrl']?> class="card-img-top" alt=<?=$newsItem['titre']?>>
    <div class="card-body">
        <h5 class="card-title"><?=$newsItem['titre']?></h5>
        <p class="card-text"><?=$newsItem['contenu']?></p>
        <p class="card-text"><small class="text-body-secondary"><?=$newsItem['datePublication']?> par <?=$newsItem['auteur']?></small></p>
    </div>
</div>
    <?php
    }
    ?>
</div>
<?php
include_once(__DIR__ . "/block/footer.php");
?>



