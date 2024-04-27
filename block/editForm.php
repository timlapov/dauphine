<div class="d-flex flex-column justify-content-center align-items-center ms-5">
    <form class="text-center p-1 col-6" method="POST" action="edit.php">
        <div class="row">
            <div class="col-2 mb-3">
                <label for="articleId" class="form-label">#id</label>
                <input type="text" class="form-control text-bg-light" id="articleId" name="articleId" placeholder="-" value="<?=$article['id']?>" readonly>
            </div>
            <div class="col-10 mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="-" value="<?=$article['titre']?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Auteur</label>
            <input type="text" class="form-control" id="author" name="author" placeholder="-" value="<?=$article['auteur']?>">
        </div>
        <div class="mb-3">
            <label for="imageUrl" class="form-label">Image (URL)</label>
            <input type="text" class="form-control" id="imageUrl" name="imageUrl" placeholder="-" value="<?=$article['imageUrl']?>">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="content"><?=$article['contenu']?></textarea>
        </div>
        <input type="submit" class="btn btn-secondary m-1 mb-3 col-6" value="Modifier">
    </form>
    <div class="m-3 text-center col-12">
        <a href="index.php" class="btn btn-danger">Accéder à la page d'administration</a>
    </div>
</div>